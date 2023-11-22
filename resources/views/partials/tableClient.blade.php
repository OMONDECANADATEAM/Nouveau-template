@foreach(\App\Models\Candidat::where('consultation_payee', true)->get() as $candidat)
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

            <span class="text-md font-weight-bold"> {{  date('Y-m-d', strtotime(  $derniereDatePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)
                ->max('date')))
               }}</span>
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


            <span class="text-md font-weight-bold"> {{
            
            $libelleTypePaiement}}
               </span>
        </td>
            
    </tr>
@endforeach
