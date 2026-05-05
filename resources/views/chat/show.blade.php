@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-4xl mx-auto h-[70vh] flex flex-col">
        <!-- Header -->
        <div class="bg-white p-6 rounded-t-[2.5rem] border-x border-t border-slate-100 flex items-center gap-4 shadow-sm">
            <a href="{{ route('chat.index') }}" class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-primary-500 transition-all">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="w-12 h-12 rounded-xl bg-primary-500 flex items-center justify-center text-white font-bold shadow-lg shadow-primary-500/20">
                {{ substr($receiver->name, 0, 1) }}
            </div>
            <div>
                <h4 class="font-black text-slate-800 leading-none">{{ $receiver->name }}</h4>
                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mt-1">En ligne</p>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chatMessages" class="flex-1 overflow-y-auto bg-slate-50/50 p-8 border-x border-slate-100 space-y-6">
            @include('chat.partials.messages')
        </div>

        <!-- Input Area -->
        <div class="bg-white p-6 rounded-b-[2.5rem] border border-slate-100 shadow-xl">
            <form id="chatForm" class="flex gap-4">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <input type="text" name="content" id="messageInput" autocomplete="off" placeholder="Tapez votre message ici..." 
                       class="flex-1 bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary-500 transition-all">
                <button type="submit" class="w-14 h-14 bg-primary-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/20 hover:scale-105 active:scale-95 transition-all">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');

    // Scroll to bottom
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    scrollToBottom();

    // AJAX Send
    chatForm.onsubmit = function(e) {
        e.preventDefault();
        const content = messageInput.value.trim();
        if(!content) return;

        const formData = new FormData(this);
        messageInput.value = '';

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                refreshMessages();
            }
        });
    };

    // AJAX Poll
    function refreshMessages() {
        fetch('{{ route("chat.show", $receiver->id) }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            const oldHeight = chatMessages.scrollHeight;
            chatMessages.innerHTML = html;
            if(chatMessages.scrollHeight > oldHeight) {
                scrollToBottom();
            }
        });
    }

    setInterval(refreshMessages, 3000);
</script>
@endpush
@endsection
