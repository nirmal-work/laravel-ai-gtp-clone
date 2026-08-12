<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo e($title ?? config('app.name')); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.11.1/build/styles/atom-one-dark.min.css">

    
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.11.1/build/highlight.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.4.7/dist/purify.min.js"></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body>
    <?php echo e($slot); ?>


    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>

</html>
<?php /**PATH E:\xampp\htdocs\lara-ai-app\resources\views/layouts/app.blade.php ENDPATH**/ ?>