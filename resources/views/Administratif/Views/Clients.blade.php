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

</head>
<style>
    /* Styles pour le formulaire d'ajout de prospect */

    .modal-content {
        border-radius: 20px;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-title {
        font-weight: bold;
        color: #333;
    }

    .modal-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        border-radius: 10px;
        color: #333; /* Changement de couleur du texte */
        background-color: #fff; /* Changement de couleur de fond */
        border: 1px solid #000; /* Bordure fine noire */
        padding: 12px; /* Padding dans le champ de texte */
    }

    .form-control:focus {
        border-color: #de3163; /* Changement de couleur de la bordure au focus */
    }

    .btn-primary {
        background-color: #de3163; /* Couleur rose */
        border: none;
        border-radius: 10px;
        transition: background-color 0.3s; /* Transition pour le changement de couleur au survol */
    }

    .btn-primary:hover {
        background-color: #111; /* Changement de couleur au survol */
    }

    .btn-primary:active {
        background-color: #1a2b3c; /* Changement de couleur au clic */
    }
</style>


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
                            class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                            <div class="p-2 border-radius-lg w-40 bg-white">
                                <input type="text " id="searchInput"
                                    class="form-control text-dark  text-lg bg-transparent border-0 p-1"
                                    placeholder="Rechercher un candidat...">
                            </div>
                            
                        </div>


                        @include('Administratif.Partials.TableCandidats')

                    </div>
                </div>
            </div>
        </div>

    </main>
    @include('partials.plugin')
</body>


</html>
