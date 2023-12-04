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
    <link rel="icon" type="image/png" href="assets/img/logos/icone-logo.png">
    <title>
        Omonde Canada - CRM
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-Vkoo8q+aEKJL2xlDkzy6viK4jQOpWiFwF8AMIE0fF6EGgU2F9nI1kxy2GRheI" crossorigin="anonymous">

</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('partials.header', ['page' => 'DASHBOARD'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                @include('partials.caisse')
                @include('partials.visiteur')
                @include('partials.client')
                @include('partials.caisseSuccursale')
            </div>
            <div class="row mt-4">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Indice visite par jour de la semaine</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2  ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 "> Indice vente par mois </h6>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mb-3">
                    
                        <div class="card h-100">
                            <div class="card-header pb-0">
                                <h6>Prochaines Consultations</h6>

                            </div>
                            <div class="card-body p-3">
                                @foreach (\App\Models\InfoConsultation::take(3)->get() as $consultation)
                                <div class="timeline timeline-one-side">
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="material-icons text-success text-gradient">videocam</i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">
                                                {{$consultation->consultante->prenoms}}
                                                {{$consultation->consultante->nom}}</h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$consultation->date_heure}}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                @endforeach


                            </div>
                   
                </div>
            </div>

        </div>
        </div>
        </div>
        <div class="row col-lg-12 p-2">
            <div class="col-lg-12 col-md-10">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h4>Historique des paiements</h4>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    <span class="font-weight-bold ms-1">10 derniers paiements</span>
                                </p>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary"></i>
                                    </a>
                                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Voir liste
                                                complète</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $utilisateurConnecte = Auth::user();
                    $entries = \App\Models\Entree::whereHas('candidat.utilisateur', function ($query) use ($utilisateurConnecte) {
                        $query->where('id_succursale', $utilisateurConnecte->id_succursale);
                    })
                    ->orderBy('date', 'desc')
                    ->take(10)
                    ->get();
                @endphp
        
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <!-- ... (rest of the code remains unchanged) ... -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entries as $entry)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-md">{{ $entry->candidat->nom }}
                                                        {{ $entry->candidat->prenom }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-md font-weight-bold mb-0">{{ $entry->montant }} FCFA </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-md font-weight-bold">{{ $entry->typePaiement->label }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="me-2 text-md font-weight-bold">{{ date('Y-m-d', strtotime($entry->date)) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


            @include('partials.footer')
        </div>
    </main>
</body>
@include('partials.plugin')

</html>
