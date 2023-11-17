                          
    $(document).ready(function () {
        // Interceptez le formulaire
        $('#contactForm').submit(function (event) {
            event.preventDefault();

            // Effectuez la soumission du formulaire avec AJAX
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    // Affichez le message de succès
                    $('#success-message').text(response.message).show();

                    // Vous pouvez également mettre à jour d'autres parties de la page ici si nécessaire

                    // Masquez le bloc d'erreurs s'il est visible
                    $('.alert-danger').hide();
                },
                error: function (error) {
                    // Gérez les erreurs si nécessaire
                    console.log(error);

                    // Affichez les erreurs dans le bloc d'erreurs
                    var errors = error.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('.alert-danger').html(errorHtml).show();
                }
            });
        });
    });
