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
  <link rel="icon" type="image/png" href= {{ asset('assets/img/logos/logo-icon.png') }}>  <title>
    OMONDE CANADA CRM | CONSULATATIONS
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
   <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
  <link  href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
   
</head>

<body class="g-sidenav-show  bg-gray-200">
  @include('partials.navbar')
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    @include('partials.header' , ['page' => 'CONSULTATIONS'])
    <!-- End Navbar -->
    <div class="row">
      <div class="col-12 ">
          <div class="card my-4">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div
                class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                <div class="p-2 border-radius-lg w-40 bg-white">
                    <input type="text " id="searchInput"
                        class="form-control text-dark  text-lg bg-transparent border-0 p-1"
                        placeholder="Recherche...">

                </div>
                     <button class="btn bg-gradient-primary circle" data-bs-toggle="modal"
                          data-bs-target="#addConsultationModal">
                          <i class="material-icons text-gradient-dark" style="font-size: 2rem;">add</i>

                      </button>

                      @include('Informatique.Partials.AddConsultation')
                  </div>
              </div>

              <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0 "  style="max-height: 700px;">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead class="col-xs-12">
                            <tr>
                                <th class="text-uppercase text-secondary  text-xxs font-weight-bolder opacity-7">
                                    LABEL
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    DATE
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    CONSULTANTE
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                    NOMBRE DE PARTICIPANTS
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                    SALLE D'ATTENTE
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder  text-center opacity-7">
                                    CANDIDATS
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                    DEMARRER
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consultations as $consultation)
                            <tr>
                                <td>
                                    <div class="d-flex px-2">
                                        <h6 class="p-2 text-md">{{ $consultation->label }}</h6>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-md font-weight-bold mb-0">{{ $consultation->date_heure}}</p>
                                </td>
                                <td>
                                
                                        <span class="font-weight-bold">{{ $consultation->consultante->nom }} {{ $consultation->consultante->prenoms }}</span>
                                   
                                </td>
                                
                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-2 text-md font-weight-bold">{{ $consultation->candidats->count() }} / {{ $consultation->nombre_candidats }}</span>
                                    </div>
                                 </td>
                                    
                               
                                <td class="align-middle">
                                 <div class="d-flex align-items-center justify-content-center">
                                     <a href="{{ url('/waiting-list/'.$consultation->id) }}" class="btn bg-dark text-white">
                                        Liste d'attente
                                    </a>
                                </div> 
                                </td>

                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="{{ $consultation->candidats->isNotEmpty() ? 'Consultation/'.$consultation->id : '#' }}" class="btn bg-gradient-dark">
                                    Voir les candidat(s)
                                    </a>
                                </td>
                                
                                <td class="align-middle">
                                    <a href="{{ $consultation->lien_zoom_demarrer}}" target="blank" class="btn btn-link text-secondary " aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">videocam</i>
                                    </a>
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
</body>

</html>