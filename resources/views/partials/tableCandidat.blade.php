@foreach ($data_candidat as $candidat)
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
            {{ date('Y-m-d', strtotime($candidat->date_enregistrement)) }}
        </span>

    </td>
    <td class="align-middle">
        <button class="btn btn-link text-secondary mb-0" data-bs-toggle="modal"
            data-bs-target="#modifierContactModal{{ $candidat->id }}">
            <i class="fa fa-pencil text-xs"></i> Modifier
        </button>
    </td>
    @include('partials.modifierContact', ['candidat' => $candidat])
</tr>
@endforeach