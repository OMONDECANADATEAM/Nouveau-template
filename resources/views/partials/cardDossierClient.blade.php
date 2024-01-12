@php
    $candidatsVersementEffectue = App\Models\Candidat::where('versement_effectuee', true)->get();
@endphp

<div class="row">
    @foreach($candidatsVersementEffectue as $candidat)
        <div class="col-xl-4 col-sm-6 mb-xl-0 mt-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-md icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">description</i>
                    </div>
                    <div class="text-end">
                        <p class="text-xl mb-0 text-capitalize">{{ $candidat->nom }} {{ $candidat->prenom }}</p>
                        <h3 class="mb-0 pt-2">Ici des icônes qui représentent les dossiers du candidat</h3>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0">
                        Ici on doit avoir une barre pour l'évolution
                    </p>
                    {{-- <a href="{{ route('ajouterDossier', ['candidatId' => $candidat->id]) }}" class="btn btn-primary">Ajouter un dossier</a> --}}
                </div>
            </div>
        </div>

        {{-- Ajoutez une nouvelle ligne après chaque quatrième carte --}}
        @if($loop->iteration % 4 == 0)
            </div><div class="row">
        @endif
    @endforeach
</div>


