<?php

namespace App\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Chat extends Component
{
    public function newConversation(): void
    {
        $this->dispatch('chat-box-reset');
    }

    public function render(): View
    {
        return view('pages.chat');
    }
}
