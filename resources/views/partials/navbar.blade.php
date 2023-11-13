<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="home"
            target="_blank">
            <img src="./assets/img/logos/logo-omonde.png" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php
                $pages = [
                    'home' => 'Dashboard',
                    'DossierContacts' => 'Contacts',
                    'DossierClients' => 'Dossier Clients',
                    'Banque' => 'Banque',
                    'OmondeTeam' => 'L\'équipe',
                    'Consultation' => 'Consultations',
                    'profile' => 'Profile',
                ];

                $currentRoute = \Request::route()->getName();
            @endphp

            @foreach ($pages as $page => $pageTitle)
                <li class="nav-item">
                    <a class="nav-link text-white {{ $currentRoute === $page ? 'active bg-gradient-primary' : '' }}"
                        href="{{ $page }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">
                                @if ($page === 'DossierClients')
                                    table_view
                                @elseif($page === 'home')
                                    dashboard
                                @elseif($page === 'DossierContacts')
                                    contacts
                                @elseif($page === 'Banque')
                                    receipt_long
                                @elseif($page === 'OmondeTeam')
                                    people
                                @elseif($page === 'Consultation')
                                    videocam
                                @elseif($page === 'profile')
                                    person
                                @else
                                    {{ $page }}
                                @endif
                            </i>
                        </div>
                        <span class="nav-link-text ms-1">{{ $pageTitle }}</span>
                    </a>
                </li>
            @endforeach

             <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li>
        </ul>
       
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ $currentRoute === 'profile' ? 'active bg-gradient-primary' : '' }}"
                    href="profile">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
