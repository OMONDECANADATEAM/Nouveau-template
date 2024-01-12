<td class="align-middle text-center">
    @if ($candidat->consultation_payee && $candidat->consultation_effectuee)
        <div class="btn-group">
            <button class="btn btn-success dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">add</i>
            </button>
            <div class="dropdown-menu" id="dropdownMenu" data-candidat-id="{{ $candidat->id }}">
            
                    @foreach(App\Models\TypeProcedure::all() as $procedure)
                        <a class="dropdown-item typeDeVisaLink" href="#" data-visa-id="{{ $procedure->id }}">{{ $procedure->label }}</a>
                    @endforeach
            
            </div>
        </div>
    @endif
</td>
