<div class="modal z-index-1 fade" id="addContactModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un contact</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajoutContact') }}" method="POST" class="text-start" id="contactForm">
                    @csrf
                    <!-- Champs Nom et Prénoms sur la même ligne -->
                    <div class="d-flex">
                        <div class="input-group input-group-outline w-30 my-3 p-2">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control" required>
                        </div>

                        <div class="input-group input-group-outline w-70 my-3 p-2">
                            <label for="prenoms" class="form-label">Prénoms</label>
                            <input type="text" name="prenoms" id="prenoms" class="form-control" required>
                        </div>
                    </div>





                    <div class="d-flex">
                        <!-- Champ Pays -->
                        <div class="input-group input-group-outline w-40 mb-3 p-2">
                            <label for="pays" class="form-label">Pays</label>
                            <input type="text" name="pays" id="pays" class="form-control" required>
                        </div>

                        <!-- Champ Ville -->
                        <div class="input-group input-group-outline w-60 mb-3 p-2">
                            <label for="ville" class="form-label">Ville</label>
                            <input type="text" name="ville" id="ville" class="form-control" required>
                        </div>
                    </div>

                    <!-- Champ Téléphone -->
                    <div class="d-flex">
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="numero_telephone" class="form-label">Téléphone</label>
                            <input type="tel" name="numero_telephone" id="numero_telephone" class="form-control"
                                required>
                        </div>

                        <!-- Champ Email -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                    </div>

                    <div class="d-flex">
                        <!-- Champ Profession -->
                        <div class="input-group input-group-outline  w-50 mb-3 p-2">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control" required>
                        </div>

                       

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="consultation_payee"
                                id="consultation_payee">
                            <label class="form-check-label" for="consultation_payee">Consultation payée</label>
                        </div>
                    </div>



                    <div class="text-center">
                        <button type="button" class="btn bg-gradient-primary w-40 my-4 mb-2"
                            id="submitFormButton">AJOUTER</button>
                        <div id="success-message" class="alert alert-success" style="display: none;">
                            L'enregistrement a été effectué avec succès!
                        </div>
                        <div class="alert alert-danger" style="display: none;"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Interceptez le formulaire
    $('#contactForm').submit(function(event) {
        event.preventDefault();

        // Effectuez la soumission du formulaire avec AJAX
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                // Affichez le message de succès
                $('#success-message').text(response.message).show();

                // Vous pouvez également mettre à jour d'autres parties de la page ici si nécessaire

                // Masquez le bloc d'erreurs s'il est visible
                $('.alert-danger').hide();
            },
            error: function(error) {
                // Gérez les erreurs si nécessaire
                console.log(error);

                // Affichez les erreurs dans le bloc d'erreurs
                var errors = error.responseJSON.errors;
                var errorHtml = '<ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                });
                errorHtml += '</ul>';
                $('.alert-danger').html(errorHtml).show();
            }
        });
    });

    // Gérez le clic sur le bouton d'ajout
    $('#submitFormButton').click(function() {
        // Soumettez le formulaire
        $('#contactForm').submit();
    });
</script>
