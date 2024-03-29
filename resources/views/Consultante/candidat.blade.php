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
    <link rel="icon" type="image/png" href={{ asset('assets/img/logos/logo-icon.png') }}>

    <title>Omonde Canada CRM | FICHE DE CONSULTATION
    </title>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />


</head>

<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->

        <!-- End Navbar -->



        <div class="row">
            <div class="col-12">
                <div class="card my-4">


                    @php
                        $sections = [
                            'Identité du candidat' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                            'Statut professionnel' => [12, 13, 14, 15, 16, 17],
                            'informations supplémentaires' => [18, 19, 20, 21, 22, 23, 24],
                            'Informations sur le conjoint' => [ 25,26, 27, 28, 29],
                        ];

                        $questions = [
                            1 => 'Nom et prenom(s)',
                            2 => 'Age',
                            3 => 'Pays',
                            4 => 'Type de visa désiré',
                            5 => 'Statut matrimonial',
                            6 => 'Avez-vous un passeport valide ?',
                            7 => 'Date d\'expiration du passeport',
                            8 => 'Avez-vous un casier judiciaire ?',
                            9 => 'Avez-vous des problèmes de santé ?',
                            10 => 'Avez-vous des enfants ?',
                            11 => 'Si oui, quel est l\'âge de vos enfants ?',
                            12 => 'Quel est votre profession/domaine de travail ?',
                            13 => 'Depuis combien de temps ?',
                            14 => 'Avez-vous une attestation de travail, bulletin de salaire et tous les autres documents relatifs à votre emploi ?',
                            15 => 'Avez-vous déjà entamé une procédure d\'immigration au Canada ?',
                            16 => 'Depuis quand ?',
                            17 => 'Quel programme ? Et quelle a été la décision ?',
                            18 => 'Avez-vous un diplôme d\'études (secondaire, professionnel, universitaire) ?',
                            19 => "Quelle est l'année du dernier diplôme obtenu ? Et lequel",
                            20 => 'Avez-vous un membre de votre famille déjà au Canada ?',
                            21 => 'Comptez-vous immigrer seul(e) ou en famille ?',
                            22 => 'Parlez-vous d\'autres langues à part le français ?',
                            23 => 'Avez-vous fait un test de connaissances linguistiques ?',
                            24 => 'Quel est son niveau de scolarité ?',
                            25 => 'Quel est votre domaine de formation ?',
                            26 => 'Quel est votre âge ?',
                            27 => 'Niveau en français',
                            28 => 'Niveau en anglais',
                            29 => 'Quel est l\'âge de vos enfants ?',
                            30 => 'Quel est leur niveau de scolarité ?',
                            31 => 'Remarque agent ?',
                        ];
                    @endphp

                    <div class="row">
                        <div class="col-12">
                            @foreach ($sections as $sectionTitle => $sectionQuestions)
                                <div class="card my-4">
                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                        <div
                                            class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                                            <h3 class="card-title text-white">{{ $sectionTitle }}</h3>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($sectionQuestions as $key)
                                                <div class="col-md-4 mb-2">
                                                    <strong
                                                        class="question d-block fs-5 mb-1">{{ $questions[$key] }}</strong>

                                                    @if ($key === 1)
                                                        <p class="answer text-right fs-5 text-capitalize">
                                                            {{ $consultation->nom ?? '' }}
                                                            {{ $consultation->prenom ?? '' }}
                                                        </p>
                                                    @elseif ($key === 2)
                                                        <p class="answer text-right fs-5 text-capitalize">
                                                            {{ $consultation->date_naissance ? now()->diffInYears($consultation->date_naissance) . ' An(s)' : '' }}
                                                        </p>
                                                    @elseif ($key === 3)
                                                        <p class="answer text-right fs-5 text-capitalize">
                                                            {{ $consultation->pays ?? '' }}
                                                        </p>
                                                    @elseif ($key === 4)
                                                        <p class="answer text-right fs-5 text-capitalize">
                                                            {{ $consultation->ficheConsultation->type_visa ?? '' }}
                                                        </p>
                                                    @else
                                                        {{-- For other questions, get the data from the "fiche consultation" table --}}
                                                        <p class="answer text-right fs-5 text-capitalize">
                                                            {{ $consultation->ficheConsultation->{'reponse' . ($key - 4)} ?? '' }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Ajouter un bouton pour afficher le CV -->
                            <div class="row d-flex justify-content-around align-items-center">
                                <div class="col-md-4">
                                    <div class="card-footer text-center">
                                        <a href="{{ asset('storage/' . $consultation->ficheConsultation->lien_cv) }}"
                                            class="btn btn-primary" target="_blank">Afficher le CV</a>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('SaveRemarque', ['id' => $consultation->id]) }}" method="post" class="d-flex align-items-center justify-content-around">
                                        @csrf
                                        <div class="input-group input-group-outline mb-3 p-2">
                                            <textarea name="consultant_opinion" id="consultant_opinion" class="form-control" placeholder="Avis du consultant..." required>{{ old('consultant_opinion', $consultation->remarque_consultante ?? '') }}</textarea>
                                            @error('consultant_opinion')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Enregistrer l'avis</button>
                                    </form>
                                </div>
                                
                                
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function () {
                // Submit form using Ajax
                $('form').submit(function (e) {
                    e.preventDefault(); // Prevent the form from submitting in the traditional way
        
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        success: function (response) {
                            // Display an alert or perform any other actions on success
                            alert('Avis enregistré avec succès!');
                        },
                        error: function (error) {
                            // Handle errors and display an alert or perform any other actions
                            alert('Une erreur s\'est produite. Veuillez réessayer.');
                        }
                    });
                });
            });
        </script>
        

        <script src="{{ asset('assets/js/material-dashboard.min.js?v=3.0.0') }}"></script>
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>

    </main>

</body>

@include('partials.plugin')

</html>
