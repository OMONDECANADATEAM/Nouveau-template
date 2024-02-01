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
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Omonde Canada - CRM | DOSSIER CONTACTS
    </title>
    <link rel="icon" type="image/png" href={{ asset('assets/img/logos/logo-icon.png') }}>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
    <script src={{ asset('assets/js/script/dossierContact.js') }}></script>
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('partials.header', ['page' => 'CONTACTS'])
        <!-- End Navbar -->
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div
                            class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                            <div class="p-2 border-radius-lg w-40 ">
                                <h3 class="text-white">
                                    Vos Rendez-Vous
                                </h3>
                            </div>

                            {{-- <div class="d-flex align-items-center justify-content-around w-40">
                                <button class="btn btn-primary filter-btn" data-filter="today">Aujourd'hui</button>
                                <button class="btn btn-primary filter-btn" data-filter="this-week">Cette semaine</button>
                                <button class="btn btn-primary filter-btn" data-filter="this-month">Ce Mois</button>
                            </div> --}}
                            
                        </div>

                        <div class="card-body px-0 pb-2 ">
                            <div class="table-responsive p-0  " style="max-height: 750px; overflow-y: auto;">
                                <table class="table align-items-center justify-content-center mb-0 bg-white">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                PROFFESSION
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                NOM
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                NUMERO
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                PROFFESSION
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($candidats as $candidat)
                                        <tr data-date="{{ Carbon\Carbon::parse($candidat->date_rdv)->format('Y-m-d') }}">
                                            <td>
                                                    <div class="d-flex px-2">

                                                        <div class="d-flex px-2">

                                                            <h6 class="p-2 text-md">
                                                                {{ Carbon\Carbon::parse($candidat->date_rdv)->locale('fr_FR')->isoFormat('DD MMMM YYYY') }}
                                                            </h6>
                                                        </div>
                                                    </div>

                                                </td>

                                                <td>
                                                    <div class="d-flex px-2">
                                                        <h6 class="p-2 text-md">{{ $candidat->nom }}
                                                            {{ $candidat->prenom }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-md font-weight-bold mb-0">
                                                        {{ $candidat->numero_telephone }}</p>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-md font-weight-bold">{{ $candidat->profession }}</span>
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
        </div>

    </main>
    @include('partials.plugin')

    <script>
        $(document).ready(function() {
            // Fonction pour appliquer les filtres
            function applyFilters() {
                // Masquer toutes les lignes
                $('tbody tr').hide();
    
                // Filtrer par date
                $('.filter-btn.active').each(function() {
                    var filter = $(this).data('filter');
                    $('tbody tr[data-date="' + filter + '"]').show();
                });
    
                // Si aucun filtre n'est sélectionné, afficher toutes les lignes
                if ($('.filter-btn.active').length === 0) {
                    $('tbody tr').show();
                }
            }
    
            // Écouteurs d'événements pour les boutons de filtre
            $('.filter-btn').on('click', function() {
                // Ajouter ou supprimer une classe active pour indiquer l'état du filtre
                $(this).toggleClass('active');
    
                // Appliquer les filtres
                applyFilters();
            });
    
            // Appliquer les filtres au chargement de la page
            applyFilters();
        });
    </script>
    
</body>


</html>
