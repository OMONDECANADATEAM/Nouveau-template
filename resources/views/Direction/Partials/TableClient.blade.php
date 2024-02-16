<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3">
        <div class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
            <div class="p-2 border-radius-lg w-40 bg-white">
                <input type="text" id="searchInput" class="form-control text-dark text-lg bg-transparent border-0 p-1" placeholder="Rechercher...">
            </div>
        </div>
    </div>
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0" style="max-height: 700px; overflow-y: auto;">
            <table class="table align-items-center justify-content-center mb-0 dataTable">
                <thead>
                    <tr>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                            NOM
                        </th>
                        <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                            TYPE VISA
                        </th>
                        
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            CONSULTANTE
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            VOIR DOSSIER
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_client->sortByDesc('date') as $candidat)
                        <tr>
                            <td>
                                <div class="d-flex px-2">
                                    <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>
                                </div>
                            </td>
            
                            <td class="align-middle text-center">

                                <span class="text-md ">
                                    @if ($candidat->proceduresDemandees)
                                        {{ $candidat->proceduresDemandees->typeProcedure->label }}
                                    @else
                                    N / A
                                    @endif
                                </span>

                            </td>
                            <td class="align-middle text-center">

                                <span class="text-md ">
                                    @if ($candidat->proceduresDemandees)
                                        {{ $candidat->proceduresDemandees->consultante->nom ?? 'null' }}  {{ $candidat->proceduresDemandees->consultante->prenoms ?? 'null' }}
                         
                                    @else
                                        N / A
                                    @endif
                                </span>

                            </td>
                            <td class="align-middle text-center">
                                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#voirDossierModal{{ $candidat->id }}">
                                    Voir Le Dossier
                                </button>
            
                                @include('Administratif.Partials.VoirDocuments')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Configuration de DataTables avec la barre de recherche personnalisée
        const tableWithSearch = $('.dataTable').DataTable({
            "language": {
                "search": "",
                "lengthMenu": "",
                "zeroRecords": "",
                "info": "",
                "infoEmpty": "",
                "infoFiltered": "",
                "paginate": {
                    "first": '<i class="material-icons">first_page</i>',
                    "last": '<i class="material-icons">last_page</i>',
                    "next": '<i class="material-icons">chevron_right</i>',
                    "previous": '<i class="material-icons">chevron_left</i>'
                }
            },
            "dom": '<"top"i>rt<"bottom"lp><"clear">',
             "drawCallback":  function () {
            
                // Ajouter les classes de Bootstrap pour centrer horizontalement
                $('.dataTables_paginate.paging_simple_numbers').addClass('d-flex justify-content-center');
                $('.bottom').addClass('d-flex justify-content-center');
   
            }
        });

        // Utilisez votre barre de recherche personnalisée pour filtrer le tableau
        $('#searchInput').on('input', function () {
            tableWithSearch.search(this.value).draw();
        });
    });
</script>
<style>
   
</style>