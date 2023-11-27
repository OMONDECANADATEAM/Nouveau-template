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

                    <div class="questionnaire-form" style="display: none;">

                        <h4>Questionnaire supplémentaire</h4>

                        <!-- Question 1 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="statut_matrimonial" class="form-label">1- Statut matrimonial</label>
                            <input type="text" name="statut_matrimonial" id="statut_matrimonial" class="form-control"
                                required>
                        </div>

                        <!-- Question 2 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="passeport_valide"
                                id="passeport_valide" checked>
                            <label class="form-check-label" for="passeport_valide">2- Avez-vous un passeport valide
                                ?</label>
                            <!-- Condition pour afficher la question suivante si la réponse est oui -->
                            <div class="question-passeport">
                                <div class="input-group input-group-outline mb-3 p-2">
                                    <label for="date_expiration_passeport" class="form-label">3- Si oui, quelle est la
                                        date d'expiration ?</label>
                                    <input type="text" name="date_expiration_passeport"
                                        id="date_expiration_passeport" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Question 4 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="casier_judiciaire">
                            <label class="form-check-label" for="casier_judiciaire">4- Avez-vous un casier judiciaire
                                ?</label>
                            <!-- Condition pour afficher la question suivante si la réponse est oui -->
                        </div>

                        <!-- Question 5 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="soucis_sante">
                            <label class="form-check-label" for="souci_sante">5- Avez-vous un des soucis de sante
                                ?</label>
                            <!-- Condition pour afficher la question suivante si la réponse est oui -->
                        </div>

                        <!-- Question 6 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="enfants" id="enfants">
                            <label class="form-check-label" for="enfants">6- Avez-vous des enfants ?</label>
                            <!-- Condition pour afficher la question suivante si la réponse est oui -->
                            <div class="question-enfants">
                                <div class="input-group input-group-outline mb-3 p-2">
                                    <label for="age_enfants" class="form-label">7- Si oui, quel est l'âge de vos
                                        enfants ?</label>
                                    <input type="text" name="age_enfants" id="age_enfants" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Question 8 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="profession_domaine_travail" class="form-label">8- Quel est votre
                                profession/domaine de travail ?</label>
                            <input type="text" name="profession_domaine_travail" id="profession_domaine_travail"
                                class="form-control">
                        </div>

                        <!-- Question 9 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="temps_travail_actuel" class="form-label">9- Depuis combien de temps ?</label>
                            <input type="text" name="temps_travail_actuel" id="temps_travail_actuel"
                                class="form-control">
                        </div>

                        <!-- Question 10 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="documents_emploi"
                                id="documents_emploi">
                            <label class="form-check-label" for="documents_emploi">10- Avez-vous une attestation de
                                travail, bulletin de salaire et tous les autres documents relatifs à votre emploi
                                ?</label>
                        </div>

                        <!-- Question 11 12 13-->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="procedure_immigration"
                                id="procedure_immigration" checked>
                            <label class="form-check-label" for="procedure_immigration">11-Avez-vous déjà entamé une
                                procédure d'immigration au Canada ?</label>
                            <div class="questions-procedure_immigration">
                                <div class="input-group input-group-outline mb-3 p-2">
                                    <label for="questions-procedure_immigration1" class="form-label">12- Depuis quand
                                        ?</label>
                                    <input type="text" name="questions-procedure-immigration1"
                                        id="questions-procedure_immigration1" class="form-control">
                                </div>
                            </div>
                            <div class="questions-procedure_immigration">
                                <div class="input-group input-group-outline mb-3 p-2">
                                    <label for="questions-procedure_immigration2" class="form-label">13- Quel
                                        programme ? et quelle a été la décision ?</label>
                                    <input type="text" name="questions-procedure-immigration2"
                                        id="questions-procedure_immigration2" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Question 14 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="diplome_etudes"
                                id="diplome_etudes">
                            <label class="form-check-label" for="diplome_etudes">14- Avez-vous un diplôme d'études
                                (secondaire, professionnel, universitaire) ?</label>
                            <div class="question-diplome-etudes" style="display: none;">
                                <div class="input-group input-group-outline mb-3 p">
                                    <label for="annee_obtention_diplome" class="form-label">Si oui, quelle est l'année
                                        d'obtention du diplôme ?</label>
                                    <input type="text" name="annee_obtention_diplome" id="annee_obtention_diplome"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- Question 15 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="membre_famille_canada"
                                id="membre_famille_canada">
                            <label class="form-check-label" for="membre_famille_canada">15- Avez-vous un membre de
                                votre famille déjà au Canada ?</label>
                        </div>

                        <!-- Question 16 -->
                        <div class="mb-3">
                            <label class="form-label">16- Comptez-vous immigrer seul(e) ou en famille ?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="immigrer_seul_ou_famille" id="immigrer_seul" value="seul">
                                <label class="form-check-label" for="immigrer_seul">Seul(e)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="immigrer_seul_ou_famille" id="immigrer_en_famille" value="famille">
                                <label class="form-check-label" for="immigrer_en_famille">En famille</label>
                            </div>
                        </div>

                        <!-- Question 17 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="langues_parlees"
                                id="langues_parlees">
                            <label class="form-check-label" for="langues_parlees">17- Parlez-vous d'autres langues à
                                part le français ?</label>
                        </div>

                        <!-- Question 18 -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="test_connaissances_linguistiques"
                                id="test_connaissances_linguistiques">
                            <label class="form-check-label" for="test_connaissances_linguistiques">18- Avez-vous fait
                                un test de connaissances linguistiques ?</label>
                        </div>

                        <h4>CONJOINT / EPOUX / EPOUSE</h4>

                        <!-- Question 1 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="niveau_scolarite_conjoint" class="form-label">1- Quel est son niveau de
                                scolarité ?</label>
                            <input type="text" name="niveau_scolarite_conjoint" id="niveau_scolarite_conjoint"
                                class="form-control" required>
                        </div>

                        <!-- Question 2 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="domaine_formation_conjoint" class="form-label">2- Quel est votre domaine de
                                formation ?</label>
                            <input type="text" name="domaine_formation_conjoint" id="domaine_formation_conjoint"
                                class="form-control" required>
                        </div>

                        <!-- Question 3 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="age_conjoint" class="form-label">3- Quel est votre âge ?</label>
                            <input type="text" name="age_conjoint" id="age_conjoint" class="form-control"
                                required>
                        </div>

                        <!-- CONNAISSANCES LINGUISTIQUES -->
                        <h4>CONNAISSANCES LINGUISTIQUES</h4>

                        <!-- Question 1 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="niveau_francais" class="form-label">1- Niveau en français</label>
                            <input type="text" name="niveau_francais" id="niveau_francais" class="form-control"
                                required>
                        </div>

                        <!-- Question 2 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="niveau_anglais" class="form-label">2- Niveau en anglais</label>
                            <input type="text" name="niveau_anglais" id="niveau_anglais" class="form-control"
                                required>
                        </div>

                        <!-- Question 3 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="age_enfants_linguistique" class="form-label">3- Quel est l'âge de vos enfants
                                ?</label>
                            <input type="text" name="age_enfants_linguistique" id="age_enfants_linguistique"
                                class="form-control" required>
                        </div>

                        <!-- Question 4 -->
                        <div class="input-group input-group-outline mb-3 p-2">
                            <label for="niveau_scolarite_enfants" class="form-label">4- Quel est leur niveau de
                                scolarité ?</label>
                            <input type="text" name="niveau_scolarite_enfants" id="niveau_scolarite_enfants"
                                class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="cv">Télécharger votre CV (PDF uniquement) :</label>
                            <input type="file" name="cv" accept=".pdf" required>
                        </div>

                    </div>


                    

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
