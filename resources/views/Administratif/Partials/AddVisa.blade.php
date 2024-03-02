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
                    <!-- Champs Statut -->
                    <div class="mb-3">
                        <label for="statut">Statut</label>
                        <select class="form-select ps-2" name="statut_id" id="statut" required>
                            @foreach (App\Models\StatutProcedure::all() as $statut)
                                <option value="{{ $statut->id }}">{{ $statut->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Champs Type de Procédure et Consultante seulement si l'utilisateur n'est pas une consultante -->
                    @if (Auth::user()->id_role_utilisateur != 0)
                        <div class="mb-3">
                            <label for="type_procedure">Type de Procédure</label>
                            <select class="form-select ps-2" name="type_procedure" id="type_procedure" required>
                                @foreach (App\Models\TypeProcedure::all() as $procedure)
                                    <option value="{{ $procedure->id }}">{{ $procedure->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="consultante_id">Consultante</label>
                            <select class="form-select ps-2" name="consultante_id" id="consultante_id">
                                <option value="" selected>Non défini</option>
                                @foreach (App\Models\consultante::all() as $consultante)
                                    <option value="{{ $consultante->id }}">{{ $consultante->nom }}
                                        {{ $consultante->prenoms }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <!-- Bouton Enregistrer -->
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    /* Styles pour le formulaire d'ajout de prospect */

    .modal-content {
        border-radius: 20px;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-title {
        font-weight: bold;
        color: #333;
    }

    .modal-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: bold;
    }

    .form-control {
        border-radius: 10px;
        color: #333;
        /* Changement de couleur du texte */
        background-color: #fff;
        /* Changement de couleur de fond */
        border: 1px solid #000;
        /* Bordure fine noire */
        padding: 12px;
        /* Padding dans le champ de texte */
    }

    .form-control:focus {
        border-color: #de3163;
        /* Changement de couleur de la bordure au focus */
    }

    .btn-primary {
        background-color: #de3163;
        /* Couleur rose */
        border: none;
        border-radius: 10px;
        transition: background-color 0.3s;
        /* Transition pour le changement de couleur au survol */
    }

    .btn-primary:hover {
        background-color: #111;
        /* Changement de couleur au survol */
    }

    .btn-primary:active {
        background-color: #1a2b3c;
        /* Changement de couleur au clic */
    }
</style>
