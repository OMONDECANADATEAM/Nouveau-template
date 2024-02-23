
    function ajouterFichiers(candidatId) {
        var form = $('#ajouterFichierForm' + candidatId)[0];
        var formData = new FormData(form);

        // Log the form data to the console
        console.log("Form Data:", formData);

        $.ajax({
            type: 'POST',
            url: '/ajouterFichiersCandidat/' + candidatId,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response && response.message) {
                    alert(response.message);

                    // Fermer le modal après un ajout réussi
                    $('#ajouterFichierModal' + candidatId).modal('hide');

                    // Actualiser la page pour afficher les changements
                    location.reload();
                } else {
                    console.error('Erreur lors de l\'ajout des fichiers: ' + (response ? response.message :
                        'Réponse non valide'));
                }
            },

            error: function (xhr, status, error) {
                console.error('Erreur AJAX: ' + status + ', ' + error);

                // Ajouter une gestion d'erreur supplémentaire si nécessaire
                alert('Erreur lors de la communication avec le serveur. Veuillez réessayer plus tard.');
            }
        });
    }

    function filterCards() {
        var searchText = document.getElementById('searchInput').value.toLowerCase();
        var cards = document.querySelectorAll('.card');

        cards.forEach(function (card) {
            card.classList.remove('show');
            card.classList.add('hidden');
        });

        var displayedCards = 0;

        cards.forEach(function (card) {
            var candidateName = card.querySelector('.text-xl').innerText.toLowerCase();

            if (candidateName.includes(searchText) && displayedCards < 3) {
                card.classList.remove('hidden');
                card.classList.add('show');
                displayedCards++;
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Récupérer l'élément de champ de recherche
        document.getElementById('searchInput').addEventListener('input', filterCards);
    });
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
        var typeDocument = document.querySelector('#typeDocument').value;

        // Appelez la fonction pour afficher la liste des documents après avoir ajouté les fichiers
        afficherListeDocuments(documents);

        // Effacez le formulaire ou effectuez d'autres actions nécessaires après l'ajout des fichiers
        document.getElementById("ajouterFichierForm" + candidatId).reset();

    }
 

  

    