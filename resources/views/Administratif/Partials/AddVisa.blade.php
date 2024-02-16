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

                    <!-- Autres champs -->
                    <div class="mb-3">
                        <label for="type_procedure">Type de Procédure</label>
                        <select class="form-select" name="type_procedure" id="type_procedure" required>
                            @foreach (App\Models\TypeProcedure::all() as $procedure)
                                <option value="{{ $procedure->id }}">{{ $procedure->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="statut">Statut</label>
                        <select class="form-select" name="statut" id="statut" required>
                            @foreach (App\Models\StatutProcedure::all() as $statut)
                                <option value="{{ $statut->id }}">{{ $statut->label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="consultante_id">Consultante ID</label>
                        <select class="form-select" name="consultante_id" id="consultante_id" required>
                            @foreach (App\Models\consultante::all() as $consultante)
                            <option value="{{ $consultante->id }}">{{ $consultante->nom }}  {{ $consultante->prenoms }}</option>
                        @endforeach
                        </select>
                    </div>
                    

                    <!-- Bouton Enregistrer -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
