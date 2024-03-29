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
    <title>
        Omonde Canada - CRM
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />
    <link  href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
   
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>


<body class="g-sidenav-show  bg-gray-200">
    @include('partials.navbar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('partials.header', ['page' => 'DASHBOARD'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                {{-- Total caisse --}}
                @include('Administratif.Partials.Caisse')
                
                {{-- Nombre de COnsultation --}}
                @include('Administratif.Partials.Consultation')
                
              
                {{-- Nombre de versements--}}
                @include('Administratif.Partials.Versement')

                @if ($hasPoste)

                @include('Administratif.Partials.Entree')

                @endif

            </div>
            <div class="row mt-4 d-flex justify-content-around">
              
                 @include('Administratif.Partials.ChartEntree')               
               
                 @include('Administratif.Partials.ProchaineConsultation')
            </div>

            <div class="row mt-4 d-flex justify-content-around">
              
                {{-- @include('Administratif.Partials.TableRdv') --}}
              
            </div>

           
                      
        </div>
        </div>
      
    </main>
</body>
<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>

@include('partials.plugin')

</html>
