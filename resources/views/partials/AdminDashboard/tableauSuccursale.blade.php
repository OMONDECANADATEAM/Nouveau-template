<div class="card my-4 pb-2">
    <div
        class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">

        <div class="p-2 border-radius-lg w-40 bg-gradient-dark">
            <input type="text" id="searchInput" class="form-control text-white  text-lg bg-transparent border-0 p-1"
                placeholder="Rechercher...">
        </div>

        <div class="p-2 d-flex align-items-center w-30 justify-content-around flex-direction-row">
            <button class="btn bg-gradient-dark" onclick="filtrerCandidats('Consultation effectuée')">Consultation
                effectuée</button>
            <button class="btn bg-gradient-dark" onclick="afficherTousLesCandidats()">Tous les candidats</button>
        </div>

    </div>

    <div class="card-body px-0">
        <div class="table-responsive p-0" style=" overflow-y: auto;">
            <table class="table align-items-center justify-content-center mb-0" id="candidatsTable">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            NOM
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            NUMERO
                        </th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            TYPE PAIEMENT
                        </th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            AGENT
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            FICHE DE CONSULTATION
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            AJOUTER À UNE CONSULTATION
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            TYPE DE VISA
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\Candidat::all() as $candidat)
                        <tr data-candidat-id="{{ $candidat->id }}">
                            <td class="align-middle">
                                <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>
                            </td>
                            <td class="align-middle">
                                <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}</p>
                            </td>
                            <td class="align-middle text-center">
                                @php
                                    $derniereDatePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)->max('date');
                                    $idTypePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)
                                        ->where('date', $derniereDatePaiement)
                                        ->value('id_type_paiement');
                                    $libelleTypePaiement = \App\Models\TypePaiement::where('id', $idTypePaiement)->value('label');
                                @endphp
                                <span class="text-md font-weight-bold">{{ $libelleTypePaiement }}</span>
                            </td>
                            <td class="align-middle text-right">
                                <span class="text-md font-weight-bold">{{ $candidat->utilisateur->name }}
                                    {{ $candidat->utilisateur->last_name }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-md font-weight-bold">
                                    <a
                                        onclick="redirectToConsultation({{ $candidat->id_info_consultation }}, {{ $candidat->id }})">
                                        <button class="btn btn-primary">
                                            Fiche de consultation
                                        </button>
                                    </a>
                                </span>
                            </td>
                            @include('partials.AdminDashboard.addConsultation')
                            @include('partials.AdminDashboard.addTypeDeVisa')
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
