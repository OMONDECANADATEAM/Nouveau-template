<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3">
        <div
            class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
            <div class="p-2 border-radius-lg w-40 bg-white">
                <input type="text" id="searchInput" class="form-control   text-lg bg-transparent border-0 p-1"
                    placeholder="Rechercher...">
            </div>
        </div>
    </div>
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0" style="min-height: 700px; max-height: 700px; overflow-y: auto;">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            NOM
                        </th>

                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            TYPE VISA
                        </th>

                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            VOIR DOSSIER
                        </th>

                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            STATUT
                        </th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            CONSULTANTE
                        </th>



                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            AJOUTER DOCUMENT
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
                                        Sans objet
                                    @endif
                                </span>

                            </td>

                            <td class="align-middle text-center">

                                <span class="text-md ">
                                    @if ($candidat->proceduresDemandees)
                                        {{ $candidat->proceduresDemandees->consultante->nom ?? 'null' }}
                                    @else
                                        Sans objet
                                    @endif
                                </span>

                            </td>

                            <td class="align-middle text-center">
                                <button class="btn bg-dark text-white" data-bs-toggle="modal"
                                    data-bs-target="#voirDossierModal{{ $candidat->id }}">
                                    Voir Le Dossier
                                </button>

                                @include('Administratif.Partials.VoirDocuments')
                            </td>




                            <td class="align-middle text-center">


                                <a class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#ajouterFichierModal{{ $candidat->id }}">
                                    <i class="material-icons opacity-10" style="font-size: 24px;">add</i>

                                </a>
                                @include('Administratif.Partials.ajoutFichierClient')



                            </td>



                        </tr>
                    @endforeach


                </tbody>
            </table>

        </div>
    </div>

</div>
