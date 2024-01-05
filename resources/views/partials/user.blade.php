<!-- Affichage des informations de l'utilisateur -->
<li class="nav-item dropdown pe-2 d-flex align-items-center bold cursor-pointer">
    <!-- Avatar de l'utilisateur -->
    <div style="width: 32px; height: 32px; overflow: hidden; border-radius: 50%; margin-right: 8px;">
       <!-- Assurez-vous que $utilisateur contient les données de l'utilisateur connecté -->
@if (auth()->user() && auth()->user()->lien_photo)
<img src="{{ asset('storage/'. auth()->user()->lien_photo) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
@else
<!-- Si l'utilisateur n'a pas de photo, affichez une image par défaut ou un espace réservé -->
<img src='{{ asset('assets/img/logos/logo-icon.png')  }}' alt="Avatar par défaut" style="width: 100%; height: 100%; object-fit: cover;">
@endif   </div>

    <!-- Informations textuelles de l'utilisateur -->
    <div class="d-flex flex-column justify-content-around">
        <!-- Nom et prénom de l'utilisateur -->
        <span style="font-weight: bold;">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>

        <!-- Récupération du poste occupé par l'utilisateur -->
        @php
            $userPoste = \DB::table('poste_occupe')->where('id', auth()->user()->id_poste_occupe)->first();
        @endphp

        <!-- Affichage du label du poste -->
        <span>{{ $userPoste->label}}</span>
    </div>
</li>

<!-- Dropdown pour les paramètres -->
<li class="nav-item dropdown pe-2 d-flex align-items-center">
    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="material-icons fs-4">settings</span>
    </a>

    <!-- Menu déroulant des paramètres -->
    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
        <!-- Bouton de déconnexion -->
        <li class="mb-2">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <!-- Bouton stylisé avec l'icône de déconnexion -->
                <button type="submit" class="dropdown-item border-radius-md bg-danger">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="material-icons fs-2">logout</span>
                        <!-- Texte "Déconnexion" -->
                        <h6 class="text-sm font-weight-normal">
                            <span class="font-weight-bold">DECONNEXION</span>
                        </h6>
                    </div>
                </button>
            </form>
        </li>
    </ul>
</li>
