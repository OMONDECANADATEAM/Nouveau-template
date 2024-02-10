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
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

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
        @php
      
       
            use Illuminate\Support\Facades\Auth;
            use Illuminate\Support\Carbon;
            Carbon::setLocale('fr');

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
                       
                        <div class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                            <h3 class="text-white text-capitalize p-2">Vos Consultations</h3>
                
                        </div>
                </div>
                        <div class="table-responsive p-0" style="max-height: 700px; overflow-y: auto;">
                            <table class="table align-items-center justify-content-center mb-0" id="candidatsTable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                            >
                                            DEMARRER
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                            style=>
                                            LABEL
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                            
                                        >
                                            DATE ET HEURE
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                            >
                                            PARTICIPANTS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($consultations as $consultation)
                                        <tr data-candidat-id="{{ $consultation->id }}"
                                            class="{{ Carbon::parse($consultation->date_heure)->isPast() ? 'table-danger' : '' }}">
                                            <td>
                                                <h6 class="p-4 text-md"> <a href="{{ $consultation->lien_zoom }}"
                                                        target="_blank">
                                                        <i class="fas fa-video"></i>
                                                    </a></h6>
                                            </td>
                                            <td>
                                                <h6 class="p-2 text-md">{{ $consultation->label }}</h6>
                                            </td>
                                            <td>
                                                <p class="text-xl  mb-0">
                                                    {{ ucwords(Carbon::parse($consultation->date_heure)->translatedFormat('j F Y / H:i')) }}
                                                </p>
                                                
                                            </td>
                                            <td>
                                                @if ($consultation->candidats->isNotEmpty())
                                                <a href="{{ url('Consultation/' . $consultation->id) }}">
                                                    <button class="btn bg-gradient-dark">
                                                        Voir les candidat(s)
                                                    </button>
                                                </a>  
                                                @else
                                                    <a href="#">

                                                        <button class="btn bg-gradient-dark">
                                                            Voir les candidat(s)
                                                        </button>

                                                    </a>
                                                @endif
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
