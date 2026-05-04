@foreach($messages as $msg)
    <div class="flex {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
        <div class="max-w-[80%] {{ $msg->sender_id === auth()->id() ? 'bg-primary-500 text-white rounded-l-2xl rounded-tr-2xl' : 'bg-white text-slate-800 rounded-r-2xl rounded-tl-2xl border border-slate-100' }} p-5 shadow-sm">
            <p class="text-sm font-medium leading-relaxed">{{ $msg->content }}</p>
            <p class="text-[9px] font-black uppercase tracking-widest mt-2 opacity-50 {{ $msg->sender_id === auth()->id() ? 'text-white' : 'text-slate-400' }}">
                {{ $msg->created_at->format('H:i') }}
                @if($msg->sender_id === auth()->id())
                    <i class="fas fa-check-double ms-1 {{ $msg->is_read ? 'text-blue-200' : 'text-white/40' }}"></i>
                @endif
            </p>
        </div>
    </div>
@endforeach
