<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OBE System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f1f5f9; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { border: none; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; padding: 40px; background: white; }
        .login-title { font-weight: 800; color: #1e293b; text-align: center; margin-bottom: 30px; letter-spacing: 1px; }
        .form-control { padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; }
        .form-control:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25); }
        .btn-primary { background-color: #0d6efd; border: none; padding: 12px; border-radius: 8px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-primary:hover { background-color: #0b5ed7; }
    </style>
</head>
<body>
    <div class="login-card">
        <h4 class="login-title">System Login</h4>
        
        @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold small text-muted">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold small text-muted">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary shadow-sm">Secure Login</button>
        </form>
    </div>
</body>
</html>
