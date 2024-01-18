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
    <link rel="icon" type="image/png" href={{ asset('assets/img/logos/logo-icon.png') }}>

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
    <link id="pagestyle" href="../../../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
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
            $questions = [
                1 => 'Type de visa désiré',
                2 => 'Date de naissance',
                3 => 'Statut matrimonial',
                4 => 'Avez-vous un passeport valide ?',
                5 => 'Date d\'expiration du passeport',
                6 => 'Avez-vous un casier judiciaire ?',
                7 => 'Avez-vous des problèmes de santé ?',
                8 => 'Avez-vous des enfants ?',
                9 => 'Si oui, quel est l\'âge de vos enfants ?',
                10 => 'Quel est votre profession/domaine de travail ?',
                11 => 'Depuis combien de temps ?',
                12 => 'Avez-vous une attestation de travail, bulletin de salaire et tous les autres documents relatifs à votre emploi ?',
                13 => 'Avez-vous déjà entamé une procédure d\'immigration au Canada ?',
                14 => 'Depuis quand ?',
                15 => 'Quel programme ? Et quelle a été la décision ?',
                16 => 'Avez-vous un diplôme d\'études (secondaire, professionnel, universitaire) ?',
                17 => "Quelle est l'année du dernier diplôme obtenu ? Et lequel",
                18 => 'Avez-vous un membre de votre famille déjà au Canada ?',
                19 => 'Comptez-vous immigrer seul(e) ou en famille ?',
                20 => 'Parlez-vous d\'autres langues à part le français ?',
                21 => 'Avez-vous fait un test de connaissances linguistiques ?',
                22 => 'Quel est son niveau de scolarité ?',
                23 => 'Quel est votre domaine de formation ?',
                24 => 'Quel est votre âge ?',
                25 => 'Niveau en français',
                26 => 'Niveau en anglais',
                27 => 'Quel est l\'âge de vos enfants ?',
                28 => 'Quel est leur niveau de scolarité ?',
                29 => 'Remarque agent ?',

            ];
        @endphp

<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                    <h5 class="card-title text-white">Fiche de consultation de {{ $consultation->nom }} {{ $consultation->prenom }}</h5>
                </div>
            </div>
            <div class="card-body">
                @php $count = 0; @endphp
                @foreach ($questions as $key => $question)
                    @if ($count % 3 === 0)
                        <div class="row">
                    @endif
                    <div class="col-md-4">
                        <div class="response-item mb-3 border shadow rounded-3 p-5 bg-gray-100">
                            <div class="d-flex align-items-center mb-2 justify-content-between">
                                <strong class="question d-block fs-6">{{ $question }}</strong>
                                <i class="material-icons text-primary mr-2">question_answer</i>
                            </div>
                            <p class="answer text-right fs-5 text-capitalize">
                                {{ $consultation->ficheConsultation->{'reponse' . $key} ?? '' }}
                            </p>
                        </div>
                    </div>
                    @php $count++; @endphp
                    @if ($count % 3 === 0 || $loop->last)
                </div>
                @endif
                @endforeach
            </div>
            <!-- Ajouter un bouton pour afficher le CV -->
            <div class="col-md-4">
                <div class="card-footer text-center">
                    <a href="{{ asset('storage/' . $consultation->ficheConsultation->lien_cv) }}" class="btn btn-primary" target="_blank">Afficher le CV</a>
                </div>
            </div>
            
        </div>
    </div>
</div>




        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="../../assets/js/material-dashboard.min.js?v=3.0.0"></script>
        <script src="../../../assets/js/core/popper.min.js"></script>
        <script src="../../assets/js/core/bootstrap.min.js"></script>
        <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script src="../../assets/js/plugins/chartjs.min.js"></script>

    </main>

</body>

@include('partials.plugin')

</html>
