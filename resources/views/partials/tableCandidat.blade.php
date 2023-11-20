@foreach(\App\Models\Candidat::all() as $candidat)
<tr >
    <td>
        <div class="d-flex px-2">
            <h6 class="p-2 text-md">{{ $candidat->nom }} {{$candidat->prenom}}</h6>
        </div>
    </td>
    <td>
        <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}</p>
    </td>
    <td>
        <span class="text-md font-weight-bold">{{ $candidat->profession }}</span>
    </td>
    <td class="align-middle text-center">
    
            <span class="me-2 text-md font-weight-bold"> {{ date('Y-m-d', strtotime($candidat->date_enregistrement)) }}</span>


    </td>
    <td class="align-middle">
        <button class="btn btn-link text-secondary mb-0" aria-haspopup="true"
            aria-expanded="false">
            <i class="fa fa-ellipsis-v text-xs"></i>
        </button>
    </td>
</tr>
@endforeach