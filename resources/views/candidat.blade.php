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
    <link rel="icon" type="image/png" href={{ asset('assets/img/logos/icon.png') }}>

    <title>Candidat - Omonde Canada - CRM
    </title>
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
    <!-- Ajoutez ces liens CDN à la section head de votre fichier Blade -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('partials.header', ['page' => 'Consultante'])
        <!-- End Navbar -->
            @php
            use Illuminate\Support\Facades\Auth;
            use Illuminate\Support\Carbon;

            $userId = Auth::id();
            $consultanteId = App\Models\consultante::where('id_utilisateur', $userId)->value('id');

            $consultations = App\Models\InfoConsultation::with(['consultante', 'candidats'])
                ->where('id_consultante', $consultanteId)
                ->orderBy('date_heure', 'desc')
                ->get();
            @endphp
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg w-auto">
                            <h4 class="text-white text-capitalize p-2">Consultation du {{date(
                                    'l j F Y',
                                    strtotime($info_consultation->date_heure))}}</h4>
                        </div>
                        
                        <div class="table-responsive p-0" style="max-height: 400px; overflow-y: auto;">                          
                        <table class="table align-items-center justify-content-center mb-0" id="candidatsTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                        style="width: 15%;">
                                        DEMARRER
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 30%;">
                                        LABEL
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 30%;">
                                        DATE ET HEURE
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 60%;">
                                        PARTICIPANTS
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $questions = [
                                        1 => 'Statut Matrimonial',
                                        2 => 'Avez-vous un passeport valide ?',
                                        3 => 'Date d\'expiration du passeport',
                                        4 => 'Avez-vous un casier judiciaire ?',
                                        5 => 'Avez-vous un des soucis de santé ?',
                                        6 => 'Avez-vous des enfants ?',
                                        7 => 'Si oui, quel est l\'âge de vos enfants ?',
                                        8 => 'Quel est votre profession/domaine de travail ?',
                                        9 => 'Depuis combien de temps ?',
                                        10 => 'Avez-vous une attestation de travail, bulletin de salaire et tous les autres documents relatifs à votre emploi ?',
                                        11 => 'Avez-vous déjà entamé une procédure d\'immigration au Canada ?',
                                        12 => 'Depuis quand ?',
                                        13 => 'Quel programme ? et quelle a été la décision ?',
                                        14 => 'Avez-vous un diplôme d\'études (secondaire, professionnel, universitaire) ?',
                                        15 => 'Avez-vous un membre de votre famille déjà au Canada ?',
                                        16 => 'Comptez-vous immigrer seul(e) ou en famille ?',
                                        17 => 'Parlez-vous d\'autres langues à part le français ?',
                                        18 => 'Avez-vous fait un test de connaissances linguistiques ?',
                                        19 => 'Quel est son niveau de scolarité ?',
                                        20 => 'Quel est votre domaine de formation ?',
                                        21 => 'Quel est votre âge ?',
                                        22 => 'Niveau en français',
                                        23 => 'Niveau en anglais',
                                        24 => 'Quel est l\'âge de vos enfants ?',
                                        25 => 'Quel est leur niveau de scolarité ?',
                                    ];
                                @endphp


                               
                                    <tr>{{ $consultation->id }}</tr>
                                        <td>

                                            <h6 class="p-2 text-md"> <a href="{{ $consultation->lien_zoom }}"
                                                    target="_blank">
                                                    <i class="fas fa-video"></i>
                                                </a></h6>

                                        </td>
                                        <td>
                                            <h6 class="p-2 text-md">{{ $consultation->nom }}</h6>
                                        </td>
                                        <td>
                                            <p class="text-md font-weight-bold mb-0">
                                                {{ $consultation->date_heure }}
                                            </p>
                                        </td>
                                       
                                          
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../assets/js/material-dashboard.min.js?v=3.0.0"></script>


    </main>

</body>

@include('partials.plugin')

</html>
