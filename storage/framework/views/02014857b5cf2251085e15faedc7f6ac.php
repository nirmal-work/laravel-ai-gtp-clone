<?php
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
?>


<aside class="w-64 flex-shrink-0 flex flex-col bg-zinc-900 border-r border-zinc-800">

    
    <div class="p-5 border-b border-zinc-800">
        <div class="flex items-center gap-3">
            <div
                class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-lg">
                L
            </div>

            <div>
                <p class="text-sm font-semibold text-white">LaraChat </p>
                <p class="text-xs text-zinc-500">Powered by Gemini</p>
            </div>
        </div>
    </div>

    
    <div class="p-4">
        <button wire:click="newConversation"
            class="w-full flex items-center gap-2 px-4 py-2.5 rounded-lg border border-zinc-700 text-zinc-400 hover:bg-zinc-800 hover:text-white transition-all duration-200 text-sm cursor-pointer">+
            New Conversation</button>
    </div>

    
    <div class="flex-1 overflow-y-auto px-2 pb-4 space-y-1" x-data="{ openMenu: null }">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div
                class="relative group rounded-lg transition-colors <?php echo e($activeConversationId === $conversation['id'] ? 'bg-zinc-800 text-white' : 'text-zinc-400 hover:bg-zinc-800/70 hover:text-white'); ?>">

                <a href="<?php echo e(route('chat', ['conversationId' => $conversation['id']])); ?>"
                    class="block truncate cursor-pointer w-full text-left px-2 pr-5 py-2 rounded-lg text-sm ">
                    <?php echo e($conversation['title']); ?></a>

                
                <button
                    x-on:click.stop="openMenu = openMenu === <?php echo \Illuminate\Support\Js::from($conversation['id'])->toHtml() ?> ? null : <?php echo \Illuminate\Support\Js::from($conversation['id'])->toHtml() ?>"
                    class="cursor-pointer absolute right-2 top-1/2 -translate-y-1/2 rounded-md p-1 text-zinc-500 opacity-0 transition hover:bg-zinc-700 hover:text-white group-hover:opacity-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="5" cy="12" r="1.8" />
                        <circle cx="12" cy="12" r="1.8" />
                        <circle cx="19" cy="12" r="1.8" />
                    </svg>
                </button>

                
                <div x-cloak x-show="openMenu === <?php echo \Illuminate\Support\Js::from($conversation['id'])->toHtml() ?>" x-on:click.outside="openMenu = null"
                    class="absolute right-2 top-9 z-50 w-36 rounded-lg border border-zinc-700 bg-zinc-900 p-1 shadow-xl">
                    <button wire:click.stop="deleteConversation('<?php echo e($conversation['id']); ?>')"
                        wire:confirm="Delete this conversation?" x-on:click="openMenu = null"
                        class="cursor-pointer flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm text-red-400 hover:bg-red-500/10">

                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                            <path d="M3 6h18" />
                            <path d="M8 6V4h8v2" />
                            <path d="M6 6l1 14h10l1-14" />
                        </svg>
                        Delete</button>
                </div>

            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <p class="px-3 py-2 text-xs text-zinc-600">No conversations yet</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>



    
    <div class="p-4 border-t border-zinc-800 space-y-2">
        <div class="flex items-center gap-2 px-2 py-2 rounded-lg bg-zinc-800/60">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="text-xs text-zinc-400">Gemini 2.5 Flash </span>
        </div>

        <p class="text-xs text-zinc-600 px-2">Built with Laravel 13 AI SDK </p>
    </div>
</aside><?php /**PATH E:\xampp\htdocs\lara-ai-app\storage\framework\views/livewire/views/098dcc74.blade.php ENDPATH**/ ?>