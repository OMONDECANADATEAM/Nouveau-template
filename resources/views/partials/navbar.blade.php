<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header center">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('home') }}" target="_blank">
            <img src="{{ asset('assets/img/logos/logo-omonde.png') }}" class="navbar-brand-img h-200 mx-auto d-block" alt="main_logo">
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
                    'dashBoardConsultante' => 'Consultante',
                    'Consultation' => 'Consultations',
                    'adminDashboard' => "Vue d'ensemble",
                    'dossier' => 'Document Clients',
                    'equipeView' => "L'equipe",
                    'documentAgent' => "Document Agent",
                ];
                $currentRoute = \Request::route()->getName();
                $currentUserRole = auth()->user()->getRole();
            @endphp
    
            @foreach ($pages as $page => $pageTitle)
                @if (
                    ($currentUserRole == 0 && $page == 'dashBoardConsultante') ||
                    ($currentUserRole == 1 && in_array($page, ['home', 'DossierContacts', 'DossierClients', 'dossier'])) ||
                    ($currentUserRole == 2 && in_array($page, ['home', 'DossierContacts', 'DossierClients', 'Banque', 'dossier'])) ||
                    ($currentUserRole == 3 && in_array($page, ['DossierContacts', 'DossierClients', 'Banque' , 'Consultation' , 'adminDashboard', 'dossier' , 'equipeView' , 'documentAgent']))
                )
                    <li class="nav-item">
                        <a class="nav-link text-white {{ $currentRoute === $page ? 'active bg-gradient-primary' : '' }}" href="{{ url($page) }}">
                            <div class="text-white text-left me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">
                                    @switch($page)
                                        @case('adminDashboard')
                                            dashboard
                                            @break
                                        @case('DossierClients')
                                            table_view
                                            @break
                                        @case('home')
                                            dashboard
                                            @break
                                        @case('DossierContacts')
                                            contacts
                                            @break
                                        @case('Banque')
                                            receipt_long
                                            @break
                                        @case('dashBoardConsultante')
                                            videocam
                                            @break
                                        @case('Consultation')
                                            videocam
                                            @break
                                        @case('dossier')
                                            folder
                                         
                                            @break
                                        @case('equipeView')
                                            groups
                                            @break
                                        @case('documentAgent')
                                            folder
                                            @break
                                        @default
                                            {{ $page }}
                                    @endswitch
                                </i>
                            </div>
                            <span class="nav-link-text ms-1">{{ $pageTitle }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
