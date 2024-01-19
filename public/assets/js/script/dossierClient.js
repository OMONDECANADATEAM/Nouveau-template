function ajouterFichiers(candidatId) {
    var form = $('#ajouterFichierForm' + candidatId)[0];
    var formData = new FormData(form);

    $.ajax({
        type: 'POST',
        url: '/ajouterFichiersCandidat/' + candidatId,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
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

        error: function(xhr, status, error) {
            console.error('Erreur AJAX: ' + status + ', ' + error);

            // Ajouter une gestion d'erreur supplémentaire si nécessaire
            alert('Erreur lors de la communication avec le serveur. Veuillez réessayer plus tard.');
        }
    });
}

function filterCards() {
    var searchText = document.getElementById('searchInput').value.toLowerCase();
    var cards = document.querySelectorAll('.card');

    cards.forEach(function(card) {
        card.classList.remove('show');
        card.classList.add('hidden');
    });

    var displayedCards = 0;

    cards.forEach(function(card) {
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
        var searchInput = document.getElementById('searchInput');

        // Récupérer tous les éléments de la table que vous souhaitez filtrer
        var rows = document.querySelectorAll('tbody tr');

        // Ajouter un gestionnaire d'événements pour l'événement input du champ de recherche
        searchInput.addEventListener('input', function () {
            var searchTerm = searchInput.value.toLowerCase();

            // Parcourir toutes les lignes de la table
            rows.forEach(function (row) {
                var nom = row.querySelector('td:first-child').textContent.toLowerCase();

                // Afficher ou masquer la ligne en fonction de la correspondance du terme de recherche
                if (nom.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

