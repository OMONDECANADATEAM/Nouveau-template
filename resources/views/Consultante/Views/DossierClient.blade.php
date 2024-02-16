<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/logo-icon.png') }}">

    <title>Omonde Canada - CRM</title>

    <!-- Inclure les polices Google -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('partials.header', ['page' => 'Consultante'])
        <!-- End Navbar -->
    
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">

                        <div
                            class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                            <h3 class="text-white text-capitalize p-2">Vos Consultations</h3>

                        </div>
                    </div>
                    <div class="table-responsive-vertical p-0" style="max-height: 700px;">
                        <table class="table align-left text-center mb-0" id="candidatsTable">
                            <thead>
                                <tr>
                                    <th class="col-md-2 text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        NOM & PRENOM(S)
                                    </th>
                                    <th class="col-md-2 text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        TYPE DE VISA
                                    </th>
                                    <th class="col-md-3 text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        STATUT
                                    </th>
                                    <th class="col-md-3 text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                       VOIR DOCUMENTS
                                    </th>

                                    <th class="col-md-3 text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        ACTIONS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidats as $candidat)
                                    <tr>
                                        <td class="align-middle">
                                            <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-md">
                                                @if ($candidat->proceduresDemandees)
                                                    {{ $candidat->proceduresDemandees->typeProcedure->label }}
                                                @else
                                                    N / A
                                                @endif
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-md">
                                                @if ($candidat->proceduresDemandees)
                                                    {{ $candidat->proceduresDemandees->statut->label ?? 'null' }}
                                                @else
                                                    N / A
                                                @endif
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn bg-dark text-white" data-bs-toggle="modal"
                                        data-bs-target="#voirDossierModal{{ $candidat->id }}">
                                        Voir Le Dossier
                                    </button>
                                    @include('Administratif.Partials.VoirDocuments')
                                        </td>
                                  
                                        <td class="align-middle text-center">
                                             <div class="dropdown">
                                                <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                                    <i class="material-icons">more_vert</i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                   
                                                    <a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#AjouterVisaModal{{ $candidat->id }}">Ajouter le Type de Visa</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
        </div>

        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->


        <!-- Inclure le script material-dashboard.min.js -->
        <script src="{{ asset('/assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>
        <script src="{{ asset('/assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('/assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('/assets/js/plugins/chartjs.min.js') }}"></script>


    </main>

</body>



</html>
z