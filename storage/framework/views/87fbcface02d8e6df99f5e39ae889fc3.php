<?php
use Livewire\Component;
use App\Ai\Agents\ChatAgent;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
?>

<div class="flex-1 flex flex-col min-w-0" x-data="chatStream">

    

    <header class="px-6 py-4 border-b border-zinc-800 bg-zinc-900/50 flex items-center justify-between flex-shrink-0">

        <div>
            <h1 class="text-sm font-semibold text-white">New Conversation</h1>
            <p class="text-xs text-zinc-500 mt-0.5">Ask me anything</p>
        </div>

        
        <button wire:click="clearChat"
            class="text-xs text-zinc-500 hover:text-zinc-300 px-3 py-1.5 rounded-md hover:bg-zinc-800 transition-colors cursor-pointer">Clear</button>
    </header>

    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6 scroll-smooth" x-ref="messagesContainer" id="messages">
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($messages) === 0): ?>
            <div class="flex flex-col items-center justify-center h-full text-center py-20">

                <div
                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-2xl font-bold text-white shadow-2xl shadow-violet-900/40 mb-5">
                    LC
                </div>

                <h2 class="text-xl font-semibold text-white mb-2">Welcome to LaraChat</h2>
                <p class="text-zinc-400 text-sm max-w-sm leading-relaxed mb-7">AI assistant powered by Google Gemini &
                    Laravel 13
                    AI SDK</p>

                
                <div class="flex flex-wrap gap-2 justify-center max-w-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['What is Laravel 13?', 'Explain Livewire 4', 'Write a PHP function', 'Tell me a fun fact']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suggestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <button wire:click="$set('input', '<?php echo e($suggestion); ?>')"
                            class="cursor-pointer px-3 py-1.5 rounded-full bg-zinc-800 border border-zinc-700 text-xs text-zinc-300 hover:border-violet-500 hover:text-white transition-all duration-200"><?php echo e($suggestion); ?></button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message['role'] === 'user'): ?>
                <div class="flex justify-end">
                    <div class="max-w-md lg:max-w-xl">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($message['attachment_path'] ?? null)): ?>
                            <?php
                                $isImage = str_starts_with($message['attachment_mime'] ?? '', 'image/');
                                $attachmentUrl = \Illuminate\Support\Facades\Storage::disk('local')->temporaryUrl(
                                    $message['attachment_path'],
                                    now()->addMinutes(30),
                                );
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isImage): ?>
                                <a href="<?php echo e($attachmentUrl); ?>" target="_blank" class="block">
                                    <img src="<?php echo e($attachmentUrl); ?>" class="rounded-xl max-h-48 border border-zinc-700"
                                        alt="<?php echo e($message['attachment_name']); ?>" />

                                </a>
                            <?php else: ?>
                                <a href="<?php echo e($attachmentUrl); ?>" target="_blank"
                                    class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-xl px-3 py-2 text-xs text-zinc-200 hover:border-violet-500 transition-colors">
                                    <svg class="w-4 h-4 text-violet-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>

                                    <span><?php echo e(Str::limit($message['attachment_name'] ?? 'Document', 24)); ?></span>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(filled($message['content'])): ?>
                            <div
                                class="bg-violet-600 text-white px-4 py-3 rounded-2xl rounded-tr-sm text-sm leading-relaxed">
                                <?php echo e($message['content']); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
            <?php else: ?>
                <div class="flex items-start gap-3">

                    
                    <div
                        class="w-7 h-7 rounded-full bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">
                        AI
                    </div>

                    
                    <div
                        class="bg-zinc-800 border border-zinc-700/50 px-4 py-3 rounded-2xl rounded-tl-sm text-sm text-zinc-100 leading-relaxed">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message['streaming'] ?? false): ?>
                            
                            <template x-if="!hasStartedStreaming">
                                <span class="text-zinc-400">LaraChat is thinking... </span>
                            </template>

                            <span x-show="hasStartedStreaming" x-html="renderMarkdown(streamingText)"
                                class="markdown-body block"></span>
                        <?php else: ?>
                            
                            <div class="max-w-md lg:max-w-2xl">
                                <span class="markdown-body"
                                    x-html="renderMarkdown(<?php echo \Illuminate\Support\Js::from($message['content'])->toHtml() ?>)"></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    </div>

    
    <div class="flex-shrink-0 px-4 pb-5 pt-3 border-t border-zinc-800 bg-zinc-900/30">
        <div class="max-w-3xl mx-auto">

            <div class="flex items-center gap-2 bg-zinc-800 border border-zinc-700 rounded-2xl px-4 py-3 focus-within:border-violet-500 transition-colors duration-200"
                :class="{ 'opacity-60 pointer-events-none': $wire.loading }">

                
                <textarea :disabled="$wire.loading" wire:model="input" wire:keydown.enter.prevent="send" rows="1"
                    placeholder="Message Lara AI Chat Agent..."
                    class="flex-1 bg-transparent text-sm text-zinc-100 placeholder-zinc-500 resize-none outline-none leading-relaxed"
                    style="min-height: 28px; height: 28px;"
                    x-on:input="$el.style.height='auto'; $el.style.height=Math.min($el.scrollHeight, 144) + 'px' "></textarea>


                
                <input type="file" wire:model="attachment" id="chat-attachment" class="hidden"
                    accept=".pdf,.jpg,.jpeg,.png" />

                
                <label for="chat-attachment"
                    class="cursor-pointer text-zinc-400 hover:text-white flex-shrink-0 w-8 h-8 rounded-xl hover:bg-zinc-700 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-zinc-400 hover:text-white" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 22 22">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                    </svg>
                </label>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($attachment): ?>
                    <div wire:loading.remove wire:target="attachment"
                        class="flex items-center gap-2 bg-zinc-700/60 rounded-lg pl-1.5 pr-2 py-1 flex-shrink-0">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(str_starts_with($attachment->getMimeType(), 'image/')): ?>
                            <img src="<?php echo e($attachment->temporaryUrl()); ?>" class="w-8 h-8 rounded object-cover"
                                alt="Image Attachment" />
                        <?php else: ?>
                            <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span
                            class="text-xs text-zinc-400 flex items-center gap-1 flex-shrink-0"><?php echo e(Str::limit($attachment->getClientOriginalName(), 20)); ?>

                        </span>
                        <button class="text-zinc-400 hover:text-white" type="button"
                            wire:click="$set('attachment', null)">X</button>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div wire:loading wire:target="attachment" class="tex-xs text-zinc-500 flex-shrink-0 px-1">Uploading...
                </div>

                
                <button wire:click="send"
                    :disabled="$wire.loading || (!$wire.input.trim() && <?php echo e($attachment ? 'false' : 'true'); ?>)"
                    class="cursor-pointer flex-shrink-0 w-8 h-8 rounded-xl bg-violet-600 hover:bg-violet-500 disabled:bg-zinc-700 disabled-opacity-50 disabled:cursor-not-allowed flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </div>

            <p class="text-center text-xs text-zinc-600 mt-2">LaraChat can make mistakes. Always verify important info.
            </p>
        </div>
    </div>
</div>



    <?php
        $__assetKey = '3613968876-0';

        ob_start();
    ?>
    <script>
        document.addEventListener('alpine:init', () => {
            function escapeHtml(text) {
                return text.replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            const renderer = new window.marked.Renderer();
            renderer.code = function(token) {
                const code = (token.text || '').replace(/^\n+|\n+$/g, '');
                const language = (token.lang || 'plaintext').trim();

                return `<div class="code-block my-3 rounded-xl overflow-hidden border border-zinc-700">
                    <div class="flex items-center justify-between px-4 py-2 bg-zinc-800 border-b border-zinc-700">
                        <span class="text-xs text-zinc-400 font-mono">${language}</span>

                        <button type="button" data-copy-code class="text-xs text-zinc-400 hover:text-white px-2 py-1 rounded hover:bg-zinc-700 transition-colors">Copy</button>
                        </div>

                    <pre class="!m-0 !rounded-none bg-zinc-900 overflow-x-auto"><code class="hljs language-${language} block p-4 text-sm text-zinc-100 font-mono leading-relaxed">${escapeHtml(code)}</code></pre></div>`;
            };


            window.marked.use({
                renderer,
                breaks: true,
                gfm: true,
            });

            // Markdown
            window.renderMarkdown = function(text) {
                const html = DOMPurify.sanitize(window.marked.parse(text || ''));

                requestAnimationFrame(() => {
                    document.querySelectorAll('.code-block pre code').forEach((block) => {
                        if (!window.hljs || block.dataset.highlighted) {
                            return;
                        }

                        window.hljs.highlightElement(block);
                    });
                });

                return html;
            };

            // Copy Button Click
            document.addEventListener('click', async (event) => {
                const button = event.target.closest('[data-copy-code]');

                if (!button) {
                    return;
                }

                const code = button.closest('.code-block')?.querySelector('code')?.innerText || '';

                await navigator.clipboard.writeText(code);
                button.innerText = 'Copied';

                setTimeout(() => {
                    button.innerText = 'Copy';
                }, 2000);
            });

            Alpine.data('chatStream', () => ({
                streamingText: '',
                hasStartedStreaming: false,
                conversationId: <?php echo \Illuminate\Support\Js::from($conversationId)->toHtml() ?>,

                init() {
                    this.$wire.on('start-stream', ({
                        message,
                        attachmentPath,
                        attachmentMime
                    }) => {
                        this.startStream(message, attachmentPath, attachmentMime);
                    });

                    // Listening event
                    this.$wire.on('conversation-reset', () => {
                        this.conversationId = null;
                        this.streamingText = '';
                        this.hasStartedStreaming = false;
                    });

                    // Scroll to bottom
                    this.scrollToBottom();

                    setTimeout(() => {
                        this.scrollToBottom();
                    }, 100);
                },

                // Function start streaming
                async startStream(message, attachmentPath = null, attachmentMime = null) {
                    this.streamingText = '';
                    this.hasStartedStreaming = false;

                    console.log('Sending conversation id: ', this.conversationId, ' and attachment ',
                        attachmentPath);

                    try {
                        const response = await fetch('<?php echo e(route('chat.stream')); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'text/event-stream',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                            },
                            body: JSON.stringify({
                                message: message,
                                conversation_id: this.conversationId,
                                attachment_path: attachmentPath,
                                attachment_mime: attachmentMime,
                            }),
                        });

                        const reader = response.body.getReader();
                        const decoder = new TextDecoder();

                        let buffer = '';

                        while (true) {
                            const {
                                done,
                                value
                            } = await reader.read();

                            if (done) break;

                            buffer += decoder.decode(value, {
                                stream: true,
                            });

                            const lines = buffer.split('\n');
                            buffer = lines.pop();

                            for (const line of lines) {

                                if (!line.startsWith('data: ')) {
                                    continue;
                                }

                                const data = line.slice(6).trim();

                                if (data === '[DONE]') {
                                    this.$wire.dispatch('stream-complete', {
                                        content: this.streamingText,
                                    });

                                    return;
                                }

                                try {

                                    const parsed = JSON.parse(data);

                                    if (parsed.content) {
                                        this.hasStartedStreaming = true;
                                        this.streamingText += parsed.content;

                                        // Auto scroll to latest message/response
                                        this.scrollToBottom();
                                    }

                                    // Capture conversation id
                                    if (parsed.conversation_id) {
                                        this.conversationId = parsed.conversation_id;

                                        // Dispatch event to refresh the sidebar
                                        Livewire.dispatch('conversation-saved', {
                                            conversationId: this.conversationId
                                        });

                                        console.log('Stored conversation id: ', this.conversationId);
                                    }

                                    if (parsed.error) {
                                        this.$wire.dispatch('stream-error');
                                        return;
                                    }

                                } catch (error) {
                                    console.error('Invalid stream data: ', error);
                                }
                            }
                        }

                        this.$wire.dispatch('stream-complete', {
                            content: this.streamingText,
                        });

                    } catch (error) {
                        console.error(error);
                        this.$wire.dispatch('stream-error');
                    }
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = this.$refs.messagesContainer;
                        container.scrollTop = container.scrollHeight;

                        requestAnimationFrame(() => {
                            container.scrollTop = container.scrollHeight;
                        });
                    });
                },
            }));
        });
    </script>
    <?php
        $__output = ob_get_clean();

        // If the asset has already been loaded anywhere during this request, skip it...
        if (in_array($__assetKey, \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys)) {
            // Skip it...
        } else {
            \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$alreadyRunAssetKeys[] = $__assetKey;

            // Check if we're in a Livewire component or not and store the asset accordingly...
            if (isset($this)) {
                \Livewire\store($this)->push('assets', $__output, $__assetKey);
            } else {
                \Livewire\Features\SupportScriptsAndAssets\SupportScriptsAndAssets::$nonLivewireAssets[$__assetKey] = $__output;
            }
        }
    ?><?php /**PATH E:\xampp\htdocs\lara-ai-app\storage\framework\views/livewire/views/66f98879.blade.php ENDPATH**/ ?>