<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['exception']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['exception']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="previous-exceptions" class="flex flex-col gap-2.5 bg-neutral-50 dark:bg-white/1 border border-neutral-200 dark:border-neutral-800 rounded-xl p-2.5 shadow-xs">
    <div class="flex items-center gap-2.5 p-2">
        <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-white/5 rounded-md w-6 h-6 flex items-center justify-center p-1">
            <?php if (isset($component)) { $__componentOriginalebc8ec9a834a8051f56913d6745a7050 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalebc8ec9a834a8051f56913d6745a7050 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.icons.alert','data' => ['class' => 'w-2.5 h-2.5 text-blue-500 dark:text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::icons.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-2.5 h-2.5 text-blue-500 dark:text-emerald-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalebc8ec9a834a8051f56913d6745a7050)): ?>
<?php $attributes = $__attributesOriginalebc8ec9a834a8051f56913d6745a7050; ?>
<?php unset($__attributesOriginalebc8ec9a834a8051f56913d6745a7050); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalebc8ec9a834a8051f56913d6745a7050)): ?>
<?php $component = $__componentOriginalebc8ec9a834a8051f56913d6745a7050; ?>
<?php unset($__componentOriginalebc8ec9a834a8051f56913d6745a7050); ?>
<?php endif; ?>
        </div>
        <h3 class="text-base font-semibold text-neutral-900 dark:text-white">Previous <?php echo e(\Illuminate\Support\Str::plural('exception', $exception->previousExceptions()->count())); ?></h3>
    </div>

    <div class="flex flex-col">
        <?php $__currentLoopData = $exception->previousExceptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $previous): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex gap-2.5 px-2">
                
                <?php if($exception->previousExceptions()->count() > 1): ?>
                    <div class="flex flex-col items-center w-6 flex-shrink-0 self-stretch">
                        <?php if($index > 0): ?>
                            <div class="h-[23.5px] w-px border-l border-dashed border-emerald-900"></div>
                        <?php else: ?>
                            <div class="h-[23.5px]"></div>
                        <?php endif; ?>

                        <div class="size-[9px] flex-shrink-0 rounded-full bg-emerald-800"></div>

                        <?php if($index < $exception->previousExceptions()->count() - 1): ?>
                            <div class="flex-1 w-px border-l border-dashed border-emerald-900"></div>
                        <?php else: ?>
                            <div class="flex-1"></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                
                <div
                    x-data="{ expanded: false }"
                    class="group/exception flex-1 min-w-0 rounded-lg my-1.5"
                    :class="{
                        'border border-neutral-200 bg-white/50 dark:bg-white/2 dark:border-white/5': expanded,
                        <?php if($exception->previousExceptions()->count() === 1): ?>
                            'border border-neutral-200 dark:border-transparent dark:bg-white/2': !expanded,
                        <?php else: ?>
                            'hover:border hover:border-neutral-200 dark:hover:border-none': !expanded,
                        <?php endif; ?>
                    }"
                >
                    
                    <div
                        class="flex gap-2.5 p-3 cursor-pointer rounded-lg"
                        :class="{ 'hover:bg-white/50 dark:hover:bg-white/2': !expanded }"
                        @click="expanded = !expanded"
                    >
                        <div
                            class="flex-1 min-w-0"
                            :class="expanded ? 'flex flex-col' : 'flex items-baseline gap-2'"
                        >
                            <h4 class="font-mono text-sm font-medium text-neutral-900 dark:text-white flex-shrink-0 max-w-full truncate"><?php echo e($previous->class()); ?></h4>
                            <p
                                class="text-sm text-neutral-500 dark:text-neutral-400"
                                :class="expanded ? 'mt-1 break-words' : 'truncate'"
                            ><?php echo e($previous->message()); ?></p>
                        </div>
                        <button
                            type="button"
                            class="flex h-6 w-6 flex-shrink-0 cursor-pointer items-center justify-center rounded-md border border-neutral-200 dark:border-white/8 group-hover/exception:text-blue-500 group-hover/exception:dark:text-emerald-500"
                            :class="{
                                'text-blue-500 dark:text-emerald-500 dark:bg-white/5': expanded,
                                'text-neutral-500 dark:text-neutral-500 dark:bg-white/3': !expanded,
                            }"
                        >
                            <?php if (isset($component)) { $__componentOriginal4400c4a71d3ea90a0e0b846e7d689a28 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4400c4a71d3ea90a0e0b846e7d689a28 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.icons.chevrons-down-up','data' => ['xShow' => 'expanded']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::icons.chevrons-down-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-show' => 'expanded']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4400c4a71d3ea90a0e0b846e7d689a28)): ?>
<?php $attributes = $__attributesOriginal4400c4a71d3ea90a0e0b846e7d689a28; ?>
<?php unset($__attributesOriginal4400c4a71d3ea90a0e0b846e7d689a28); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4400c4a71d3ea90a0e0b846e7d689a28)): ?>
<?php $component = $__componentOriginal4400c4a71d3ea90a0e0b846e7d689a28; ?>
<?php unset($__componentOriginal4400c4a71d3ea90a0e0b846e7d689a28); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal7348bb70f498d75e0a91acc6a707f136 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7348bb70f498d75e0a91acc6a707f136 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.icons.chevrons-up-down','data' => ['xShow' => '!expanded','xCloak' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::icons.chevrons-up-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-show' => '!expanded','x-cloak' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7348bb70f498d75e0a91acc6a707f136)): ?>
<?php $attributes = $__attributesOriginal7348bb70f498d75e0a91acc6a707f136; ?>
<?php unset($__attributesOriginal7348bb70f498d75e0a91acc6a707f136); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7348bb70f498d75e0a91acc6a707f136)): ?>
<?php $component = $__componentOriginal7348bb70f498d75e0a91acc6a707f136; ?>
<?php unset($__componentOriginal7348bb70f498d75e0a91acc6a707f136); ?>
<?php endif; ?>
                        </button>
                    </div>

                    
                    <div x-show="expanded" x-cloak class="flex flex-col gap-1.5 p-3">
                        <?php $__currentLoopData = $previous->frameGroups(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($group['is_vendor']): ?>
                                <?php if (isset($component)) { $__componentOriginal449787012edfba29f0e80f325065fad5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal449787012edfba29f0e80f325065fad5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.vendor-frames','data' => ['frames' => $group['frames']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::vendor-frames'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['frames' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($group['frames'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal449787012edfba29f0e80f325065fad5)): ?>
<?php $attributes = $__attributesOriginal449787012edfba29f0e80f325065fad5; ?>
<?php unset($__attributesOriginal449787012edfba29f0e80f325065fad5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal449787012edfba29f0e80f325065fad5)): ?>
<?php $component = $__componentOriginal449787012edfba29f0e80f325065fad5; ?>
<?php unset($__componentOriginal449787012edfba29f0e80f325065fad5); ?>
<?php endif; ?>
                            <?php else: ?>
                                <?php $__currentLoopData = $group['frames']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $frame): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginalc7c58c6d16fe849872fb25ad6e9b8407 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7c58c6d16fe849872fb25ad6e9b8407 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-exceptions-renderer::components.frame','data' => ['frame' => $frame]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('laravel-exceptions-renderer::frame'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['frame' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($frame)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7c58c6d16fe849872fb25ad6e9b8407)): ?>
<?php $attributes = $__attributesOriginalc7c58c6d16fe849872fb25ad6e9b8407; ?>
<?php unset($__attributesOriginalc7c58c6d16fe849872fb25ad6e9b8407); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7c58c6d16fe849872fb25ad6e9b8407)): ?>
<?php $component = $__componentOriginalc7c58c6d16fe849872fb25ad6e9b8407; ?>
<?php unset($__componentOriginalc7c58c6d16fe849872fb25ad6e9b8407); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\Users\Hasanur Rahman Kabir\Documents\University File Management System\University-File-Management-System\vendor\laravel\framework\src\Illuminate\Foundation\Providers/../resources/exceptions/renderer/components/previous-exceptions.blade.php ENDPATH**/ ?>