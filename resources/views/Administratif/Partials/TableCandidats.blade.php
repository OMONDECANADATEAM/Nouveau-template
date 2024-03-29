<div class="card-body px-0 pb-2">
    <div class="table-responsive p-0" style="max-height: 700px; min-height: 700px; overflow-y: auto;">
        <table class="table align-items-center justify-content-center mb-0">
            <thead>
                <tr>
                    <th class=" col-md-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                        NOM
                    </th>
                    <th class="col-md-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        NUMERO
                    </th>
                    <th class="col-md-2 text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        PROFFESSION
                    </th>
                    <th class="col-md-2 text-uppercase text-secondary text-xxs font-weight-bolder text-left opacity-7 ps-2">
                        DATE DE CONSULTATION
                    </th>
                    <th class="col-md-2 text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                        ACTIONS
                    </th>
                    </th>
                </tr>
            </thead>
            <tbody>


                @foreach ($clients as $candidat)
                     <tr>
                        <td>
                            <div class="d-flex px-2">
                                <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>
                            </div>
                        </td>
                        <td>
                            <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}</p>
                        </td>
                        <td>
                            <span class="text-md font-weight-bold">{{ $candidat->profession }}</span>
                        </td>

                        <td class="align-middle text-left">
                            @if ($candidat->consultation_payee && $candidat->infoConsultation)
                                <span class="text-md font-weigh-norman">{{ $candidat->dateFormatee }}</span>
                            @else
                                {{ $candidat->dossiers->documents ?? 'N / A' }}
                            @endif

                        </td>

                        <td class="align-middle text-center">
                            <div class="dropdown">
                                <button class="btn btn-primary" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown">
                                    <i class="material-icons">more_vert</i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"data-bs-toggle="modal"
                                        data-bs-target="#modifierContactModal{{ $candidat->id }}">Ajouter ou modifier
                                        Fiche de Consultation</a>

                                    <a class="dropdown-item"data-bs-toggle="modal"
                                        data-bs-target="#AjouterOuModifierConsultationModal{{ $candidat->id }}">Ajouter
                                        ou Modifier Consultation</a>

                                    
                                </div>
                            </div>
                        </td>
                        @include('Administratif.Partials.AjouterOuModifierFiche', [
                            'candidat' => $candidat,
                        ])
                        @include('Administratif.Partials.AjouterOuModifierConsultation', [
                            'candidat' => $candidat,
                        ])  
                      
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

</div>
