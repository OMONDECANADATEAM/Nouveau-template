<div class="modal z-index-1 fade" id="addContactModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un contact</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('ajoutContact') }}" method="POST" class="text-start" id="contactForm"  enctype="multipart/form-data">
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

                    <div class="d-flex">
                        <!-- Champ Téléphone -->
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
                        <div class="input-group input-group-outline w-50 mb-3 p-2">
                            <label for="profession" class="form-label">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control" required>
                        </div>

                        <!-- Case à cocher pour la consultation payée -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="consultation_payee"
                                id="consultation_payee">
                            <label class="form-check-label" for="consultation_payee">Consultation payée</label>
                        </div>
                    </div>

                    <!-- Questionnaire (affiché si consultation payée) -->

               @include('partials.questionnaireConsultation')
                    <div class="text-center">
                        <button type="submit" class="btn bg-gradient-primary w-40 my-4 mb-2"
                            id="submitFormButton">AJOUTER</button>
                        @if (session('error'))
                            <div class="alert text-sm text-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
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



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupère la case à cocher et la div du questionnaire
        var checkbox = document.getElementById('consultation_payee');
        var questionnaireDiv = document.getElementById('questionnaire');

        // Ajoute un écouteur d'événement pour le changement de la case à cocher
        checkbox.addEventListener('change', function() {
            // Affiche ou masque le questionnaire en fonction de l'état de la case à cocher
            questionnaireDiv.style.display = checkbox.checked ? 'block' : 'none';
        });
    });
    $(document).ready(function() {
        // Cacher le questionnaire supplémentaire au chargement de la page
        $('.questionnaire-form').hide();

        // Écouter le changement de la checkbox consultation_payee
        $('#consultation_payee').change(function() {
            if (this.checked) {
                // Afficher le questionnaire supplémentaire si la checkbox est cochée
                $('.questionnaire-form').show();
            } else {
                // Cacher le questionnaire supplémentaire si la checkbox est décochée
                $('.questionnaire-form').hide();
            }
        });

        // Écouter le changement de la checkbox passeport_valide
        $('#passeport_valide').change(function() {
            if (this.checked) {
                // Afficher la question suivante si la checkbox est cochée
                $('.question-passeport').show();
            } else {
                // Cacher la question suivante si la checkbox est décochée
                $('.question-passeport').hide();
            }
        });

        // Écouter le changement de la checkbox casier_judiciaire
        $('#casier_judiciaire').change(function() {
            if (this.checked) {
                // Afficher la question suivante si la checkbox est cochée
                $('.question-casier-judiciaire').show();
            } else {
                // Cacher la question suivante si la checkbox est décochée
                $('.question-casier-judiciaire').hide();
            }
        });

        $('#enfants').change(function() {
            if (this.checked) {
                // Afficher la question suivante si la checkbox est cochée
                $('.question-enfants').show();
            } else {
                // Cacher la question suivante si la checkbox est décochée
                $('.question-enfants').hide();
            }
        });

        // Écouter le changement de la checkbox passeport_valide
        $('#procedure_immigration').change(function() {
            if (this.checked) {
                // Afficher la question suivante si la checkbox est cochée
                $('.questions-procedure_immigration').show();
            } else {
                // Cacher la question suivante si la checkbox est décochée
                $('.questions-procedure_immigration').hide();
            }
        })
    });

    document.getElementById('diplome_etudes').addEventListener('change', function() {
        // Obtenez l'élément de la question 18
        var questionDiplomeEtudes = document.querySelector('.question-diplome-etudes');

        // Affichez ou masquez la question 18 en fonction de l'état de la case à cocher de la question 15
        questionDiplomeEtudes.style.display = this.checked ? 'block' : 'none';
    });
</script>
