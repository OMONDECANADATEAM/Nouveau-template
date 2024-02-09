<!-- Modal pour ajouter une entrée -->
<div class="modal fade z-index-2" id="AjouterVisaModal{{ $candidat->id }}" tabindex="-1" role="dialog"
    aria-labelledby="ajouterEntreeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterEntreeModalLabel">Ajouter le Type de Procedure</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('Administratif.ModifierTypeVisa', ['id' => $candidat->id]) }}" method="POST">
                    @csrf
                    <!-- Champs Candidat -->
                    <input type="hidden" name="candidat_id" value="{{ $candidat->id }}">
                    
                    <div class="input-group input-group-outline mb-3 p-2 d-flex align-items-center justify-content-between">
                        <!-- Récupérer la liste des types de procédures triés par nom -->
                        @foreach (App\Models\TypeProcedure::all() as $procedure)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type_procedure" id="procedure{{ $procedure->id }}" value="{{ $procedure->id }}" required>
                                <label class="form-check-label" for="procedure{{ $procedure->id }}">{{ $procedure->label }}</label>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Bouton Enregistrer -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
