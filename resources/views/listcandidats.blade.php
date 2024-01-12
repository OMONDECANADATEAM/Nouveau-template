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
    <link rel="icon" type="image/png" href={{ asset('assets/img/logos/icon.png') }}>

    <title>Liste des candidats - Omonde Canada - CRM
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
    <link id="pagestyle" href="../../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <!-- Inclure le script SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Inclure les stylesheets SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <!-- Ajoutez ces liens CDN à la section head de votre fichier Blade -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


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
                                        N°
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 30%;">
                                        NOM
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 30%;">
                                        PRENOMS
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 60%;">
                                        VOIR FICHE DE CONSULTATION
                                    </th>

                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                        style="width: 60%;">
                                        CONSULTATION EFFECTUÉE
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($info_consultation->candidats as $candidat)
                                <tr data-candidat-id="{{ $candidat->id }}">
                                    <td>
                                        <h6 class="p-2 text-md">
                                            Candidat n° {{$candidat->id}}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="p-2 text-md">{{ $candidat->nom }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="p-2 text-md">{{ $candidat->prenom }}</h6>
                                    </td>
                                    <td>
                                        <a href="{{$info_consultation->id}}/{{$candidat->id}}">
                                            <button class="btn bg-gradient-primary">
                                                Voir fiche de consultation
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                      <div class="d-flex align-items-center justify-content-around">

                                        <a href="{{ route('toggleConsultation', ['candidatId' => $candidat->id, 'status' => "yes"]) }}" data-status="yes" data-candidat-id="{{ $candidat->id }}">
                                            <i class="material-icons text-success text-bolder icon-large toggle-consultation" style="font-size: 2rem;">check</i>
                                        </a>
                                        
                                        <a href="{{ route('toggleConsultation', ['candidatId' => $candidat->id, 'status' => "no"]) }}" data-status="no" data-candidat-id="{{ $candidat->id }}">
                                            <i class="material-icons text-danger icon-large text-bolder toggle-consultation"  style="font-size: 2rem">close</i>
                                        </a>

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
        <script src="../../assets/js/material-dashboard.min.js?v=3.0.0"></script>
        <script src="./assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/chartjs.min.js"></script>


    </main>
  
    <script>
        $(document).ready(function () {
            $('.toggle-consultation').click(function (e) {
                e.preventDefault();
    
                var status = $(this).data('status');
                var candidatId = $(this).data('candidat-id');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
                $.ajax({
                    url: '/toggle-consultation/' + candidatId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: { status: status },
                    success: function (response) {
                        if (response.success) {
                            alert('Statut de consultation mis à jour avec succès.');
    
                            // Vous pouvez ajouter d'autres actions ici si nécessaire
                        } else {
                            alert('Erreur : ' + response.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Erreur lors de la mise à jour du statut de consultation. Veuillez réessayer.');
                    }
                });
            });
        });
    </script>
    
    
    
</body>

@include('partials.plugin')

</html>
