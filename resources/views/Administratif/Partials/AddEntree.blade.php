<!-- Modal pour ajouter une entrée -->
<div class="modal fade z-index-2" id="ajouterEntreeModal" tabindex="-1" role="dialog"
    aria-labelledby="ajouterEntreeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterEntreeModalLabel">Ajouter un paiement</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajoutEntree') }}" method="post">
                    @csrf
                    <div class="row p-3">
                        <!-- Champs Montant -->
                        <div class="col-6 mb-3 p-2">
                            <label for="montant" class="form-label">Montant :</label>
                            <input type="text" name="montant" id="montant" class="form-control" required>
                        </div>

                        <!-- Champs Date -->
                        <div class=" col-6 mb-3 p-2">
                            <label for="datetime" class="form-label">Date et Heure :</label>
                            <input type="datetime-local" name="datetime" id="datetime" class="form-control" required
                                value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        
                    </div>
                    <!-- Champs Candidat -->
                    <div class="mb-3 p-2">
                        <label for="candidat" class="form-label">Candidat :</label>
                        <select name="candidat" id="candidat" class="form-control" required>
                            <!-- Option vide au début pour laisser le choix par défaut -->
                            <option value="" disabled selected>Choisissez un candidat</option>
                            <!-- Récupérer la liste des candidats triés par nom -->
                            @foreach (auth()->user()->candidats()->orderBy('nom')->get() as $candidat)
                                <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if (session('error'))
                        <div class="alert text-sm text-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Bouton Enregistrer -->
                    <div class="d-flex justify-content-around">
                        <!-- Bouton Fermer -->
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>

                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
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
        color: #333; /* Changement de couleur du texte */
        background-color: #fff; /* Changement de couleur de fond */
        border: 1px solid #000; /* Bordure fine noire */
        padding: 12px; /* Padding dans le champ de texte */
    }

    .form-control:focus {
        border-color: #de3163; /* Changement de couleur de la bordure au focus */
    }

    .btn-primary {
        background-color: #de3163; /* Couleur rose */
        border: none;
        border-radius: 10px;
        transition: background-color 0.3s; /* Transition pour le changement de couleur au survol */
    }

    .btn-primary:hover {
        background-color: #111; /* Changement de couleur au survol */
    }

    .btn-primary:active {
        background-color: #1a2b3c; /* Changement de couleur au clic */
    }
</style>
