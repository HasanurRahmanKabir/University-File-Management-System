# <?php echo e($exception->class()); ?> - <?php echo $exception->title(); ?>


<?php echo $exception->message(); ?>


PHP <?php echo e(PHP_VERSION); ?>

Laravel <?php echo e(app()->version()); ?>

<?php echo e($exception->request()->httpHost()); ?>


## Stack Trace

<?php $__currentLoopData = $exception->frames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $frame): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($index); ?> - <?php echo e($frame->file()); ?>:<?php echo e($frame->line()); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($exception->previousExceptions()->isNotEmpty()): ?>
## Previous <?php echo e(\Illuminate\Support\Str::plural('exception', $exception->previousExceptions()->count())); ?>

<?php $__currentLoopData = $exception->previousExceptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $previous): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

### <?php echo e($index + 1); ?>. <?php echo e($previous->class()); ?>


<?php echo $previous->message(); ?>


<?php $__currentLoopData = $previous->frames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $frame): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php echo e($index); ?> - <?php echo e($frame->file()); ?>:<?php echo e($frame->line()); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

## Request

<?php echo e($exception->request()->method()); ?> <?php echo e(\Illuminate\Support\Str::start($exception->request()->path(), '/')); ?>


## Headers

<?php $__empty_1 = true; $__currentLoopData = $exception->requestHeaders(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
* **<?php echo e($key); ?>**: <?php echo $value; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
No header data available.
<?php endif; ?>

## Route Context

<?php $__empty_1 = true; $__currentLoopData = $exception->applicationRouteContext(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php echo e($name); ?>: <?php echo $value; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
No routing data available.
<?php endif; ?>

## Route Parameters

<?php if($routeParametersContext = $exception->applicationRouteParametersContext()): ?>
<?php echo $routeParametersContext; ?>

<?php else: ?>
No route parameter data available.
<?php endif; ?>

## Database Queries

<?php $__empty_1 = true; $__currentLoopData = $exception->applicationQueries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as ['connectionName' => $connectionName, 'sql' => $sql, 'time' => $time]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
* <?php echo e($connectionName); ?> - <?php echo $sql; ?> (<?php echo e($time); ?> ms)
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
No database queries detected.
<?php endif; ?>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/renderer/markdown.blade.php ENDPATH**/ ?>