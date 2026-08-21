<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo e($globalSettings['login_subtitle'] ?? 'Welcome to the Official File Management Portal of our University. Sign in to access your dashboard.'); ?>">
    <title><?php echo e($globalSettings['login_tab_title'] ?? 'Sign In — University OBE Portal'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            /* University dark gradient */
            background: #0b1622;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(5,150,105,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 90%, rgba(14,165,233,0.09) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(99,102,241,0.05) 0%, transparent 60%);
            position: relative;
            overflow: hidden;
        }

        /* Subtle dot grid pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        /* Subtle top accent line */
        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #059669, #0891b2, #6366f1, #059669);
            background-size: 200% 100%;
            animation: shimmer 4s linear infinite;
            z-index: 2;
        }

        @keyframes shimmer {
            0%   { background-position: 0% 0%; }
            100% { background-position: 200% 0%; }
        }

        .card {
            background: #fff;
            border-radius: 18px;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.06),
                0 20px 60px rgba(0,0,0,0.5),
                0 4px 16px rgba(0,0,0,0.3);
            padding: 48px 44px 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }
        .logo-icon {
            width: 60px; height: 60px;
            background: linear-gradient(145deg, #059669, #0d9488);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 14px;
            box-shadow: 0 4px 16px rgba(5,150,105,0.25);
        }
        .logo-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.3px;
        }
        .logo-tagline {
            font-size: 0.78rem;
            color: #888;
            margin-top: 3px;
        }

        /* Heading */
        .heading {
            text-align: center;
            margin-bottom: 28px;
        }
        .heading h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.5px;
        }
        .heading p {
            font-size: 0.875rem;
            color: #888;
            margin-top: 5px;
        }

        /* Error */
        .alert {
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 0.85rem;
            color: #c0392b;
            margin-bottom: 20px;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }
        .alert i { margin-top: 1px; flex-shrink: 0; }

        /* Field */
        .field { margin-bottom: 16px; }
        .field label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
        }
        .input-wrap { position: relative; }
        .input-wrap input {
            width: 100%;
            height: 48px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            padding: 0 44px 0 14px;
            font-size: 0.93rem;
            font-family: inherit;
            color: #111;
            background: #fafafa;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .input-wrap input::placeholder { color: #bbb; }
        .input-wrap input:focus {
            border-color: #059669;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
        }
        .input-wrap input.err {
            border-color: #ef4444;
            background: #fef9f9;
        }
        .eye-btn {
            position: absolute;
            right: 13px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #bbb; cursor: pointer;
            font-size: 0.9rem; padding: 4px;
            display: flex; align-items: center;
            transition: color 0.15s;
        }
        .eye-btn:hover { color: #666; }

        /* Submit */
        .btn {
            width: 100%;
            height: 50px;
            background: #059669;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(5,150,105,0.22);
            letter-spacing: -0.1px;
        }
        .btn:hover {
            background: #047857;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(5,150,105,0.3);
        }
        .btn:active { transform: translateY(0); }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 28px;
            font-size: 0.75rem;
            color: #aaa;
        }

        /* ===== RESPONSIVE ===== */

        /* Small phones (< 480px) */
        @media (max-width: 480px) {
            html, body {
                padding: 16px;
                align-items: flex-start;
                padding-top: 40px;
            }
            .card {
                padding: 32px 22px 28px;
                border-radius: 14px;
            }
            .logo-icon {
                width: 52px; height: 52px;
                font-size: 1.3rem;
                border-radius: 13px;
            }
            .logo-name { font-size: 1.05rem; }
            .heading h1 { font-size: 1.3rem; }
            .input-wrap input { height: 46px; font-size: 0.9rem; }
            .btn { height: 48px; font-size: 0.9rem; }
        }

        /* Very small phones (< 360px — e.g. older Android) */
        @media (max-width: 360px) {
            html, body {
                padding: 12px;
                padding-top: 28px;
            }
            .card {
                padding: 28px 18px 24px;
                border-radius: 12px;
            }
            .logo-icon {
                width: 46px; height: 46px;
                font-size: 1.1rem;
                border-radius: 11px;
                margin-bottom: 10px;
            }
            .logo-name { font-size: 0.95rem; }
            .logo-tagline { font-size: 0.72rem; }
            .heading { margin-bottom: 20px; }
            .heading h1 { font-size: 1.15rem; letter-spacing: -0.3px; }
            .heading p { font-size: 0.82rem; }
            .field { margin-bottom: 14px; }
            .field label { font-size: 0.78rem; }
            .input-wrap input { height: 44px; font-size: 0.88rem; padding: 0 40px 0 12px; }
            .btn { height: 46px; font-size: 0.88rem; margin-top: 6px; }
            .footer { font-size: 0.7rem; margin-top: 20px; }
        }

        /* Ultra-small devices (< 320px — oldest phones, smartwatches) */
        @media (max-width: 320px) {
            html, body { padding: 10px; padding-top: 20px; }
            .card { padding: 22px 14px 20px; border-radius: 10px; }
            .logo { margin-bottom: 20px; }
            .logo-icon { width: 40px; height: 40px; font-size: 1rem; border-radius: 10px; }
            .logo-name { font-size: 0.88rem; }
            .logo-tagline { display: none; }
            .heading h1 { font-size: 1.05rem; }
            .heading p { font-size: 0.78rem; }
            .input-wrap input { height: 42px; font-size: 0.85rem; padding: 0 38px 0 11px; border-radius: 8px; }
            .btn { height: 44px; font-size: 0.85rem; border-radius: 8px; }
            .alert { font-size: 0.78rem; padding: 9px 12px; }
            .footer { font-size: 0.65rem; margin-top: 16px; }
        }
    </style>
</head>
<body>

<div class="card">

    <div class="logo">
        <?php if(isset($globalSettings['login_logo']) && $globalSettings['login_logo']): ?>
            <div style="display: flex; justify-content: center; margin-bottom: 15px;">
                <img src="<?php echo e(asset('storage/' . $globalSettings['login_logo'])); ?>" alt="Logo" style="max-width: 100%; height: 60px; object-fit: contain;">
            </div>
        <?php else: ?>
            <div class="logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="logo-name">UniOBE Portal</div>
            <div class="logo-tagline"><?php echo e($globalSettings['login_logo_tagline'] ?? 'University File Management System'); ?></div>
        <?php endif; ?>
    </div>

    <div class="heading">
        <h1><?php echo e($globalSettings['login_title'] ?? 'Sign in to your account'); ?></h1>
        <p><?php echo e($globalSettings['login_subtitle'] ?? 'Enter your credentials below to continue'); ?></p>
    </div>

    <?php if($errors->any()): ?>
    <div class="alert">
        <i class="fas fa-circle-exclamation"></i>
        <div><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($error); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('login.post')); ?>" method="POST" id="loginForm">
        <?php echo csrf_field(); ?>
        <div class="field">
            <label for="email">Email or Student ID</label>
            <div class="input-wrap">
                <input type="text" id="email" name="email"
                    value="<?php echo e(old('email')); ?>"
                    placeholder="you@university.edu or ID"
                    class="<?php echo e($errors->any() ? 'err' : ''); ?>"
                    required autofocus autocomplete="username">
            </div>
        </div>
        <div class="field">
            <label for="password">Password</label>
            <div class="input-wrap">
                <input type="password" id="password" name="password"
                    placeholder="••••••••"
                    class="<?php echo e($errors->any() ? 'err' : ''); ?>"
                    required autocomplete="current-password">
                <button type="button" class="eye-btn" onclick="togglePwd()" title="Show/hide password">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>
        </div>
        <button type="submit" class="btn" id="submitBtn">Sign in</button>
    </form>

    <div class="footer"><?php echo e($globalSettings['footer_copyright'] ?? '© ' . date('Y') . ' University OBE System. All rights reserved.'); ?></div>

</div>

<?php $hideValidationToast = true; ?>
<?php echo $__env->make('partials.sweetalert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
    function togglePwd() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        icon.className = pwd.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
    }
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.textContent = 'Signing in...';
    });
</script>
</body>
</html>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\resources\views/auth/login.blade.php ENDPATH**/ ?>