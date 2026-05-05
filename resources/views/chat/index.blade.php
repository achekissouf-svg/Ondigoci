@extends('layouts.app')

@section('content')
<div class="container py-10">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-black text-primary-900 mb-8 tracking-tighter">Mes Messages</h1>
        
        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-100 overflow-hidden">
            <div class="divide-y divide-slate-50">
                @forelse($contacts as $contact)
                    <a href="{{ route('chat.show', $contact->id) }}" class="flex items-center gap-6 p-8 hover:bg-slate-50 transition-all group">
                        <div class="w-16 h-16 rounded-2xl bg-primary-500 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-primary-500/20 group-hover:scale-105 transition-transform">
                            {{ substr($contact->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-black text-slate-800">{{ $contact->name }}</h4>
                            @php
                                $lastMsg = \App\Models\Message::where(function($q) use ($contact) {
                                    $q->where('sender_id', auth()->id())->where('receiver_id', $contact->id);
                                })->orWhere(function($q) use ($contact) {
                                    $q->where('sender_id', $contact->id)->where('receiver_id', auth()->id());
                                })->latest()->first();
                            @endphp
                            <p class="text-sm text-slate-500 truncate">{{ $lastMsg ? $lastMsg->content : 'Commencez la discussion' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $lastMsg ? $lastMsg->created_at->diffForHumans() : '' }}</p>
                        </div>
                    </a>
                @empty
                    <div class="p-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-6">
                            <i class="fas fa-comments text-2xl"></i>
                        </div>
                        <p class="text-slate-400 font-medium italic">Aucun message pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
