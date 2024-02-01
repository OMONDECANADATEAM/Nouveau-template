<div class="modal z-index-1 fade" id="modifierContactModal{{ $candidat->id }}" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier Contact</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('Commercial.ModifierProspect', $candidat->id) }}" method="POST" class="text-start"
                    id="modifierContactForm{{ $candidat->id }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Champs Nom et Prénoms sur la même ligne -->
                    <div class="d-flex">
                        <div class="input-group input-group-outline w-30 my-3 p-2">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control"
                                value="{{ $candidat->nom }}" required>
                        </div>

                        <div class="input-group input-group-outline w-70 my-3 p-2">
                            <label for="prenoms" class="form-label">Prénoms</label>
                            <input type="text" name="prenoms" id="prenoms" class="form-control"
                                value="{{ $candidat->prenom }}" required>
                        </div>
                    </div>

                    <div class="d-flex">
                        <!-- Champ Pays -->
                        <div class="input-group input-group-outline w-40 mb-3 p-2">
                            <label for="pays" class="form-label">Pays</label>
                            <input type="text" name="pays" id="pays" class="form-control"
                                value="{{ $candidat->pays }}" required>
                        </div>

                        <!-- Champ Ville -->
                        <div class="input-group input-group-outline w-60 mb-3 p-2">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" name="ville" id="ville" class="form-control"
                                value="{{ $candidat->ville }}" required>
                        </div>
                    </div>

                    <!-- Champ Téléphone -->
                    <div class="d-flex">
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="numero_telephone" class="form-label">Téléphone</label>
                            <input type="tel" name="numero_telephone" id="numero_telephone" class="form-control"
                                value="{{ $candidat->numero_telephone }}" required>
                        </div>

                        <!-- Champ Email -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $candidat->email }}" required>
                        </div>
                    </div>

                    <div class="d-flex">
                        <!-- Champ Profession -->
                        <div class="input-group input-group-outline w-50 mb-3 p-2">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control"
                                value="{{ $candidat->profession }}" required>
                        </div>


                        <div class="input-group input-group-outline w-50 mb-3 p-2">
                            <label for="date_rdv" class="form-label">Date Rendez Vous</label>
                            <input type="date" name="date_rdv" id="date_rdv" class="form-control"
                                value="{{ $candidat->date_rdv }}">
                        </div>
                    </div>
            </div>

            <div class="text-center d-flex justify-content-around">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success"
                    onclick="$('#modifierContactForm{{ $candidat->id }}').submit()">Enregistrer les
                    modifications</button>
            </div>

        </div>

        </form>
    </div>
</div>
</div>
</div>
