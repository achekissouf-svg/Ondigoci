@extends('layouts.app')
@section('title', 'Mon Profil')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4" style="color: #1e5a9e;">Mon Profil <i class="fas fa-user-circle ms-2"></i></h1>

            <!-- Profile Information Card -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0"><i class="fas fa-info-circle text-primary me-2"></i> Informations Personnelles</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom Complet</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adresse E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone', $user->telephone) }}" placeholder="Ex: +225 07 00 00 00 00">
                            @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        @if($user->role === 'admin' || $user->role === 'boutique')
                            @php $boutique = $user->boutique; @endphp
                            @if($boutique)
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-success"><i class="fab fa-whatsapp"></i> Numéro WhatsApp Boutique</label>
                                    <input type="text" name="whatsapp_boutique" class="form-control" 
                                           value="{{ old('whatsapp_boutique', $boutique->whatsapp) }}" placeholder="Ex: 2250700000000">
                                    <small class="text-muted">Ce numéro sera utilisé pour les boutons "Contacter sur WhatsApp". (Format: 225... sans le +)</small>
                                </div>
                            @endif
                        @endif

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn fw-bold text-white px-4" style="background: #1e5a9e; border-radius: 8px;">
                                Enregistrer les modifications
                            </button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success fw-bold small animate-fade"><i class="fas fa-check"></i> Modifié !</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="card shadow-sm border-0 mb-5" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0"><i class="fas fa-lock text-warning me-2"></i> Changer le Mot de Passe</h5>
                </div>
                <div class="card-body p-4">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                            @error('current_password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                            @error('password', 'updatePassword')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn fw-bold text-white px-4" style="background: #ff6b35; border-radius: 8px;">
                                Mettre à jour le mot de passe
                            </button>
                            @if (session('status') === 'password-updated')
                                <span class="text-success fw-bold small animate-fade"><i class="fas fa-check"></i> Mis à jour !</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content">
            @csrf
            @method('delete')
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Supprimer le compte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Êtes-vous sûr de vouloir supprimer votre compte ? Veuillez entrer votre mot de passe pour confirmer.</p>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                    @error('password', 'userDeletion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-danger fw-bold">Confirmer la suppression</button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeOut {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; }
    }
    .animate-fade {
        animation: fadeOut 3s forwards;
    }
    .form-control:focus {
        border-color: #1e5a9e;
        box-shadow: 0 0 0 0.25rem rgba(30, 90, 158, 0.25);
    }
</style>
@endsection

