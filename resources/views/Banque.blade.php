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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Omonde Canada - CRM
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css"
        integrity="sha256-g8CHiBpZ2yM5x6wv+eBS5ixvlL11GRl9YL/FgjzxpKA=" crossorigin="anonymous" />

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"
        integrity="sha256-+QiYzEw3vFwDZ/5Dp0uTZJLWiIjvu2/KY1aAQa4lWao=" crossorigin="anonymous"></script>

</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('partials.header', ['page' => 'BANQUE'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">

            <div class="row">
                <div class="col-lg-12">


                    @php
                        use Carbon\Carbon;
                        use Illuminate\Support\Facades\Auth;

                        $moisActuel = Carbon::now()->format('m');

                        $utilisateurConnecte = Auth::user();

                        $totalCaisseMoisActuel = \App\Models\Entree::whereMonth('date', $moisActuel)
                            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                                $query->where('id_succursale', $utilisateurConnecte->id_succursale);
                            })
                            ->sum('montant');

                        $totalDepenseMoisActuel = \App\Models\Depense::whereMonth('date', $moisActuel)
                            ->whereHas('utilisateur', function ($query) use ($utilisateurConnecte) {
                                $query->where('id_succursale', $utilisateurConnecte->id_succursale);
                            })
                            ->sum('montant');
                    @endphp
                    @php

                        $moisActuel = Carbon::now()->format('m');

                        $totalDepenseMoisActuel = \App\Models\Depense::whereMonth('date', $moisActuel)->sum('montant');

                        // Date de début et de fin de la période
                        $dateDebut = Carbon::now();
                        $dateFin = Carbon::now();

                        // Date de début et de fin de semaine
                        $dateDebutSemaine = $dateDebut->startOfWeek();
                        $dateFinSemaine = $dateFin->endOfWeek();

                    @endphp

                    <div class="row">
                        <div class="col-xl-6 mb-4">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                        <i class="material-icons opacity-10">account_balance</i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h5 class="text-center mb-0">Paiements</h5>
                                    <span class="text-xs">{{ Carbon::now()->format('F') }}</span>
                                    <hr class="horizontal dark my-3">
                                    <h4 class="mb-5 text-center text-success">
                                        {{ number_format($totalCaisseMoisActuel, 0, '.', ' ') }} FCFA</h4>
                                </div>
                                <div class="col-12 d-flex justify-content-center align-item-center w-100">
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#ajouterEntreeModal">
                                        <i class="material-icons">add</i> Ajouter une entrée
                                    </button>
                                </div>
                                @include('partials.addEntree')
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div
                                        class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                        <i class="material-icons opacity-10">wallet</i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h5 class="text-center mb-0">Dépenses</h5>
                                    <span class="text-xs">{{ Carbon::now()->format('F') }}</span>
                                    <hr class="horizontal dark my-3">
                                    <h4 class="mb-5 text-center text-danger">
                                        {{ number_format($totalDepenseMoisActuel, 0, '.', ' ') }} FCFA</h4>
                                </div>

                                <div class="col-12 d-flex justify-content-center align-item-center w-100">
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#ajouterDepenseModal">
                                        <i class="material-icons">add</i> Ajouter une dépense
                                    </button>
                                </div>
                                @include('partials.addDepenses')
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-12 mt-6">
                    <div class="card h-100 mb-4">
                        <div class="card-header pb-0 px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-0">TRANSACTIONS</h6>
                                </div>
                                <div
                                    class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                                    <i class="material-icons me-2 text-lg">date_range</i>
                                    <small>{{ $dateDebutSemaine->format('d F') }} -
                                        {{ $dateFinSemaine->format('d F') }}</small>

                                </div>
                            </div>
                        </div>
                        @php
                            $startOfWeek = now()->startOfWeek();
                            $endOfWeek = now()->endOfWeek();

                            $depenses = \App\Models\Depense::whereBetween('date', [$startOfWeek, $endOfWeek])->get();
                            $entrees = \App\Models\Entree::whereBetween('date', [$startOfWeek, $endOfWeek])->get();

                            // Organiser les dépenses par jour
                            $depensesParJour = [];
                            foreach ($depenses as $depense) {
                                $jour = Carbon::parse($depense->date)->format('l');
                                // 'l' donne le nom du jour de la semaine
                                $depensesParJour[$jour][] = $depense;
                            }

                            // Organiser les entrées par jour
                            $entreesParJour = [];
                            foreach ($entrees as $entree) {
                                $jour = Carbon::parse($entree->date)->format('l');
                                $entreesParJour[$jour][] = $entree;
                            }
                        @endphp
                        <div class="card-body pt-4 p-3">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Cette semaine</h6>

                            @foreach (array_reverse(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) as $jour)
                                @if (isset($depensesParJour[$jour]) || isset($entreesParJour[$jour]))
                                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                                        {{ $jour }}</h6>
                                    <ul class="list-group">
                                        @foreach ($depensesParJour[$jour] ?? [] as $depense)
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <button
                                                        class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                                        <i class="material-icons text-lg">expand_more</i>
                                                    </button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">{{ $depense->raison }}</h6>
                                                        <span class="text-xs">{{ $depense->date }}</span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                                    - ${{ abs($depense->montant) }}
                                                </div>
                                            </li>
                                        @endforeach

                                        @foreach ($entreesParJour[$jour] ?? [] as $entree)
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <button
                                                        class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                                        <i class="material-icons text-lg">expand_less</i>
                                                    </button>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">
                                                            @php
                                                                $label = \App\Models\TypePaiement::where('id', $entree->id_type_paiement)->value('label');
                                                            @endphp
                                                            {{ $label }}
                                                        </h6>
                                                        <span class="text-xs">{{ $entree->date }}</span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                    + ${{ $entree->montant }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        </div>



                    </div>
                </div>
            </div>
            @include('partials.footer')
        </div>

    </main>
    @include('partials.plugin')
</body>

</html>
