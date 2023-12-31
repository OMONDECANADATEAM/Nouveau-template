
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h4 class="text-white text-capitalize ps-3">Dossier Client</h4>
        </div>
    </div>
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0" style="max-height: 400px; overflow-y: auto;">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            NOM
                        </th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            NUMERO</th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            PROFFESSION</th>
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            DATE DE PAIEMENT</th>
                            <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            TYPE PAIEMENT </th>
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
                        <td>
                            <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}</p>
                        </td>
                        <td>
                            <span class="text-md font-weight-bold">{{ $candidat->profession }}</span>
                        </td>
                        <td class="align-middle text-center">
                
                            <span class="text-md font-weight-bold">
                                {{ date(
                                    'd-m-Y',
                                    strtotime($derniereDatePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)->max('date')),
                                ) }}</span>
                        </td>
                
                        <td class="align-middle text-center">
                
                            @php
                                // Récupérez l'ID du type de paiement
                $idTypePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)
                    ->where('date', $derniereDatePaiement)
                    ->value('id_type_paiement');
                
                // Récupérez le libellé du type de paiement
                $libelleTypePaiement = \App\Models\TypePaiement::where('id', $idTypePaiement)->value('label');
                            @endphp
                
                
                            <span class="text-md font-weight-bold"> {{ $libelleTypePaiement }}
                            </span>
                        </td>
                
                    </tr>
                @endforeach
                
                
                </tbody>
            </table>
            
        </div>
    </div>
   
</div>