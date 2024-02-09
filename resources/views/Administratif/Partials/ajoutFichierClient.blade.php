<!-- Modal -->
<div class="modal z-index-2 fade" id="ajouterFichierModal{{ $candidat->id }}" aria-labelledby="ajouterFichierModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterFichierModalLabel">Ajouter des fichiers au
                    dossier de {{ $candidat->nom }} {{ $candidat->prenom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ajouterFichierForm{{ $candidat->id }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        <!-- Ajoutez un champ de sélection pour le type de document -->
                        <div class="me-3">
                            <select class="form-select" id="typeDocument" name="typeDocument" required>
                                <!-- Ajoutez les options de type de document en conséquence -->
                                <option value="curruculum">CV</option>
                                <option value="lettre_motivation">Lettre de motivation</option>
                                <!-- Ajoutez d'autres options selon vos besoins -->
                            </select>
                        </div>

                        <!-- Ajoutez le champ de fichier -->
                        <div class="input-group me-3">
                            <input type="file" class="form-control border rounded-3 p-2"
                                id="fichiers{{ $candidat->id }}" name="fichiers[]" multiple style="height: 3rem;">
                            <label class="input-group-text" for="fichiers{{ $candidat->id }}">Parcourir</label>
                        </div>

                        <!-- Bouton pour ajouter une nouvelle ligne -->
                        <button type="button" class="btn btn-primary"
                            onclick="ajouterNouvelleLigne({{ $candidat->id }})">+</button>
                    </div>

                    <div class="text-end d-flex justify-content-around">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-success w-30"
                            onclick="ajouterFichiers({{ $candidat->id }})">Ajouter</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    function ajouterNouvelleLigne(candidatId) {
        // Sélectionnez le formulaire
        var formulaire = document.getElementById("ajouterFichierForm" + candidatId);

        // Sélectionnez la première ligne (conteneur flex d'origine)
        var premiereLigne = formulaire.querySelector(".mb-3.d-flex.align-items-center");

        // Clonez la première ligne
        var nouvelleLigne = premiereLigne.cloneNode(true);

        // Effacez le champ de fichier dans la nouvelle ligne
        var champFichier = nouvelleLigne.querySelector(".input-group");
        champFichier.innerHTML =
            '<input type="file" class="form-control border rounded-3 p-2" name="fichiers[]" multiple style="height: 3rem;">' +
            '<label class="input-group-text" for="fichiers' + candidatId + '">Parcourir</label>';

        // Insérez la nouvelle ligne avant les boutons
        formulaire.insertBefore(nouvelleLigne, formulaire.querySelector(".text-end"));
        // Récupérez le type de document sélectionné
        var typeDocument = document.getElementById('typeDocument').value;

        // Appelez la fonction pour afficher la liste des documents après avoir ajouté les fichiers
        afficherListeDocuments(documents);

        // Effacez le formulaire ou effectuez d'autres actions nécessaires après l'ajout des fichiers
        document.getElementById("ajouterFichierForm" + candidatId).reset();

    }
</script>
