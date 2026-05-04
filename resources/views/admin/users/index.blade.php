@extends('layouts.admin')

@section('header_title', 'Gestion des Utilisateurs')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Liste des Utilisateurs</h2>
        <p class="text-sm text-slate-500">Gérez les comptes clients et vendeurs.</p>
    </div>
</div>

<div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary-500 text-white border-0">
                    <tr>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest">Nom</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest">Email</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest">Rôle</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest text-center">Statut</th>
                        <th class="px-6 py-4 border-0 text-[10px] font-black uppercase tracking-widest text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="fw-bold">{{ $user->name }}</div>
                            <small class="text-muted">Inscrit le {{ $user->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            @if($user->role === 'boutique')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Vendeur</span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Client</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($user->statut === 'bloque')
                                <span class="badge bg-danger">Bloqué</span>
                            @else
                                <span class="badge bg-success">Actif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            @if($user->statut === 'bloque')
                                <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-unlock me-1"></i> Débloquer
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bloquer cet utilisateur ?')">
                                        <i class="fas fa-ban me-1"></i> Bloquer
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Aucun utilisateur trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

