
         $(document).ready(function() {

            $('.DateConsForm').submit(function(e) {
                e.preventDefault(); // Empêche la soumission du formulaire par défaut
    
                // Afficher la page de chargement
                $('#loading').addClass('show');
                
                var form = $(this);
                var formData = form.serialize(); // Sérialisez les données du formulaire
    
                $.ajax({
                      headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: form.attr('method'), // Récupère la méthode du formulaire (POST)
                    url: form.attr('action'), // Récupère l'URL du formulaire
                    data: formData, // Les données à envoyer
                    success: function(response) {
                        // Succès de la requête AJAX - retirez la classe pour le fond sombre
                        $('body').removeClass('loading-body');
    
                        // Affiche une alerte de succès
                        alert('Les modifications ont été enregistrées avec succès.');
    
                        // Ferme le modal
                        var modalId = form.data('modal-id');
                        $('#AjouterOuModifierConsultationModal' + modalId).modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Erreur lors de la requête AJAX - retirez la classe pour le fond sombre
                      // Affiche une alerte d'erreur
                        alert('Une erreur s\'est produite lors de l\'enregistrement des modifications. Veuillez réessayer.');
                    },
                    complete: function() {
                        // La soumission du formulaire est terminée - masquer la page de chargement
                        $('#loading').removeClass('show');
                    }
                });
            });

           
            
        });
