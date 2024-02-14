<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header center">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('home') }}" target="_blank">
            <img src="{{ asset('assets/img/logos/logo-omonde.png') }}" class="navbar-brand-img h-200 mx-auto d-block"
                alt="main_logo">
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">
    <div class="w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @php
                $pages = [
                    // Pages Commerciaux
                    'Consultante.Dashboard' => 'Dashboard',

                    // Pages Commerciaux
                    'Commercial.Dashboard' => 'Dashboard',
                    'Commercial.Contact' => 'Contacts',
                    'Commercial.RendezVous' => 'Rendez-Vous',

                    // Pages Administratif
                    'Administratif.Dashboard' => 'Dashboard',
                    'Administratif.Clients' => 'Clients',
                    'Administratif.DossierClients' => 'Dossier Client',
                    'Administratif.Banque' => 'Banque',
                    'Administratif.Consultation' => 'Consultation',

                    //Pages DIrection
                    'Direction.Dashboard' => 'Dashboard',
                    'Direction.DossierClient' => 'Dossier Client',
                    'Direction.Banque' => 'Banque',
                    'Direction.Consultation' => 'Consultation',
                    'Direction.Team' => 'L\'equipe',

                    // Other Pages
                    'DossierContacts' => 'Contacts',
                    'DossierClients' => 'Dossier Clients',
                    'Banque' => 'Banque',
                    'dashBoardConsultante' => 'Consultante',
                    'Consultation' => 'Consultations',
                    'adminDashboard' => "Vue d'ensemble",
                    'dossier' => 'Document Clients',
                    'equipeView' => "L'equipe",
                    'documentAgent' => 'Document Agent',
                ];
                $currentRoute = \Request::route()->getName();
                $currentUserRole = auth()->user()->getRole();
            @endphp

            @foreach ($pages as $page => $pageTitle)
                @if (
                    ($currentUserRole == 0 && $page == 'Consultante.Dashboard') ||
                        ($currentUserRole == 1 &&
                            in_array($page, ['Commercial.Dashboard', 'Commercial.Contact', 'Commercial.RendezVous'])) ||
                        ($currentUserRole == 2 &&
                            in_array($page, [
                                'Administratif.Dashboard',
                                'Administratif.Clients',
                                'Administratif.DossierClients',
                                'Administratif.Banque',
                                'Administratif.Consultation',
                            ])) ||
                        ($currentUserRole == 3 &&
                            in_array($page, [
                                'DossierContacts',
                                'DossierClients',
                                'Banque',
                                'Consultation',
                                'adminDashboard',
                                'dossier',
                                'equipeView',
                                'documentAgent',
                            ])) ||
                        ($currentUserRole == 4 &&
                            in_array($page, [
                                'Direction.Dashboard',
                                'DossierClients',
                                'Direction.Banque',
                                'Consultation',
                                'adminDashboard',
                                'dossier',
                                'equipeView',
                                'documentAgent',
                            ])))
                    <li class="nav-item">
                        <a class="nav-link text-white {{ $currentRoute === $page ? 'active bg-gradient-primary' : '' }}"
                            href="{{ route($page) }}">
                            <div class="text-white text-left me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">
                                    @switch($page)
                                        @case('adminDashboard')
                                            dashboard
                                        @break

                                        @case('Administratif.Dashboard')
                                            dashboard
                                        @case('Direction.Dashboard')
                                            dashboard
                                        @break

                                        @case('Administratif.Clients')
                                            contacts
                                        @break

                                        @case('Administratif.DossierClients')
                                            folder
                                        @break

                                        @case('Administratif.Consultation')
                                            groups
                                        @break

                                        @case('Administratif.Banque')
                                            account_balance
                                        @break

                                        @case('DossierClients')
                                            table_view
                                        @break

                                        @case('Commercial.Dashboard')
                                            dashboard
                                        @break

                                        @case('DossierContacts')
                                            contacts
                                        @break

                                        @case('Commercial.Contact')
                                            contacts
                                        @break

                                        @case('Commercial.RendezVous')
                                            handshake
                                        @break

                                        @case('Banque')
                                            receipt_long
                                        @break

                                        @case('Direction.Banque')
                                        receipt_long
                                        @break

                                        @case('Consultante.Dashboard')
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
