<div class="card my-4">
    <div
        class="card-header p-2 position-relative mt-n4 mx-3 z-index-1 d-flex justify-content-between align-items-center">
        <div class="p-2 border-radius-lg w-40 bg-gradient-dark">
            <input type="text" id="searchInput" class="form-control text-white  text-lg bg-transparent border-0 p-1" placeholder="Rechercher...">
        </div>
        
        <div class="p-2 d-flex align-items-center w-30 justify-content-around flex-direction-row">
            <button class="btn bg-gradient-dark" onclick="filtrerCandidats('Consultation effectuée')">Consultation
                effectuée</button>
            <button class="btn bg-gradient-dark" onclick="afficherTousLesCandidats()">Tous les candidats</button>
        </div>
    </div>

    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0" id="candidatsTable">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            NOM
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            NUMERO</th>
                       
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            TYPE PAIEMENT </th>
                       <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            AGENT</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                            FICHE DE CONSULTATION
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\Candidat::all() as $candidat)
                        <tr data-candidat-id="{{ $candidat->id }}">
                            <td>

                                <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>

                            </td>
                            <td>
                                <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}</p>
                            </td>
                           
                            <td class="align-middle text-center">
                                @php
                                    $derniereDatePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)->max('date');
                                    $idTypePaiement = \App\Models\Entree::where('id_candidat', $candidat->id)
                                        ->where('date', $derniereDatePaiement)
                                        ->value('id_type_paiement');
                                    $libelleTypePaiement = \App\Models\TypePaiement::where('id', $idTypePaiement)->value('label');
                                @endphp
                                <span class="text-md font-weight-bold"> {{ $libelleTypePaiement }}</span>
                            </td>
                            
                            <td class="align-middle text-align-right">
                                <span class="text-md font-weight-bold">{{ $candidat->utilisateur->name }}
                                    {{ $candidat->utilisateur->last_name }}</span>
                            </td>
                            <td>
                                <span class="text-md font-weight-bold">
                                    <a onclick="redirectToConsultation({{$candidat->id_info_consultation}}, {{$candidat->id}})">
                                        <button class="btn btn-primary">
                                            Fiche de consultation
                                        </button>
                                    </a>      
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                @if ($candidat->consultation_payee && !$candidat->consultation_effectuee)
                                    <div class="btn-group">
                                        <button class="btn btn-success dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">add</i>
                                        </button>
                                        
                                        <div class="dropdown-menu" id="dropdownMenu"
                                            data-candidat-id="{{ $candidat->id }}">
                                            @php
                                                $prochainesConsultations = App\Models\InfoConsultation::whereDate('date_heure', '>', now())
                                                    ->take(3)
                                                    ->get();

                                                foreach ($prochainesConsultations as $consultation) {
                                                    $dateHeure = \Carbon\Carbon::parse($consultation['date_heure']);
                                                    $formattedDateHeure = $dateHeure->format('d M Y H:i'); // Format à ajuster selon vos besoins
                                                    echo '<a class="dropdown-item consultation-link" href="#" data-consultation-id="' . $consultation->id . '">' . $consultation['label'] . ' - ' . $formattedDateHeure . '</a>';
                                                            }
                                            @endphp
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>



<script>
     document.addEventListener('DOMContentLoaded', function () {
        $('#candidatsTable').DataTable();
    });
    function filtrerCandidats() {
        var rows = document.querySelectorAll("#candidatsTable tbody tr");

        rows.forEach(function(row) {
            var idCandidat = row.getAttribute('data-candidat-id');

            // Ajoutez ici votre condition de filtrage
            if (candidatConsultationPayee(idCandidat) && !consultationEffectuee(idCandidat)) {
                row.style.display = "table-row"; // Afficher la ligne
            } else {
                row.style.display = "none"; // Masquer la ligne
            }
        });
    }

    function candidatConsultationPayee(idCandidat) {
        // Ajoutez ici la logique pour vérifier si la consultation est payée
        // Vous pouvez utiliser une requête AJAX ou une autre méthode pour vérifier cette condition côté serveur
        // Pour l'exemple, je suppose que vous avez un champ consultation_payee dans la base de données
        var consultationPayee = {!! json_encode(App\Models\Candidat::pluck('consultation_payee', 'id')->all()) !!}[idCandidat];

        return consultationPayee === 1; // Assurez-vous d'adapter cette condition à votre modèle de données
    }

    function consultationEffectuee(idCandidat) {
        // Ajoutez ici la logique pour vérifier si la consultation a été effectuée
        // Vous pouvez utiliser une requête AJAX ou une autre méthode pour vérifier cette condition côté serveur
        // Pour l'exemple, je suppose que vous avez un champ consultation_effectuee dans la base de données
        var consultationEffectuee = {!! json_encode(App\Models\Candidat::pluck('consultation_effectuee', 'id')->all()) !!}[idCandidat];

        return consultationEffectuee === 1; // Assurez-vous d'adapter cette condition à votre modèle de données
    }
</script>
<script>
    function filtrerCandidats(filtre) {
        var rows = document.querySelectorAll("#candidatsTable tbody tr");

        rows.forEach(function(row) {
            var idCandidat = row.getAttribute('data-candidat-id');

            switch (filtre) {
                case 'Pas de consultation':
                    if (!candidatConsultationPayee(idCandidat) || consultationEffectuee(idCandidat)) {
                        row.style.display = "none";
                    } else {
                        row.style.display = "table-row";
                    }
                    break;
                case '10 derniers':
                    // Ajoutez ici la logique pour afficher les 10 derniers candidats
                    // Vous pouvez utiliser une requête AJAX ou une autre méthode pour obtenir ces candidats côté serveur
                    // Pour l'exemple, je suppose que vous avez une méthode pour récupérer les 10 derniers candidats
                    var dixDerniersCandidats = {!! json_encode(
                        App\Models\Candidat::take(10)->get()->pluck('id')->all(),
                    ) !!};
                    if (dixDerniersCandidats.includes(parseInt(idCandidat))) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                    break;
                case 'Consultation effectuée':
                    if (!candidatConsultationEffectuee(idCandidat)) {
                        row.style.display = "none";
                    } else {
                        row.style.display = "table-row";
                    }
                    break;
            }
        });
    }

    function candidatConsultationEffectuee(idCandidat) {
        // Ajoutez ici la logique pour vérifier si la consultation a été effectuée
        // Vous pouvez utiliser une requête AJAX ou une autre méthode pour vérifier cette condition côté serveur
        // Pour l'exemple, je suppose que vous avez un champ consultation_effectuee dans la base de données
        var consultationEffectuee = {!! json_encode(App\Models\Candidat::pluck('consultation_effectuee', 'id')->all()) !!}[idCandidat];

        return consultationEffectuee === 1; // Assurez-vous d'adapter cette condition à votre modèle de données
    }

    function afficherTousLesCandidats() {
        var rows = document.querySelectorAll("#candidatsTable tbody tr");

        rows.forEach(function(row) {
            row.style.display = "table-row";
        });
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.consultation-link').click(function(event) {
            event.preventDefault(); // Empêcher le comportement par défaut du lien

            // Récupérer l'ID de la consultation depuis l'attribut de données
            var consultationId = $(this).data('consultation-id');

            // Récupérer l'ID du candidat depuis l'attribut de données
            var candidatId = $(this).closest('tr').data('candidat-id');

            // Récupérer le jeton CSRF depuis la balise meta
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Fermer toutes les alertes précédentes
            $('.alert').alert('close');

            // Faire une requête AJAX pour ajouter le candidat à la consultation
            $.ajax({
                url: '/ajouterCandidatAConsultation',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    consultation_id: consultationId,
                    candidat_id: candidatId, // Envoyer l'ID du candidat
                    // Autres données du candidat à envoyer si nécessaire
                },
                success: function(response) {
                    // Gérer la réponse du serveur
                    if (response.success) {
                        // Le candidat a été ajouté avec succès
                        alert('Candidat ajouté avec succès à la consultation');
                    } else {
                        // Il y a eu une erreur lors de l'ajout du candidat
                        if (response.message.includes('déjà inscrit')) {
                            // Gérer le cas où le candidat est déjà inscrit
                            if (confirm('Le candidat est déjà inscrit à une consultation. Voulez-vous changer de consultation ?')) {
                                // L'utilisateur a choisi de changer de consultation
                                // Vous pouvez ajouter ici la logique pour gérer le changement de consultation
                                console.log('Changer de consultation...');
                            } else {
                                // L'utilisateur a annulé le changement de consultation
                                console.log('Annuler le changement de consultation...');
                            }
                        } else {
                            // Gérer d'autres erreurs
                            alert('Erreur : ' + response.message);
                        }
                    }
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Il y a eu une erreur lors de la requête AJAX
                    alert('Erreur lors de la requête AJAX : ' + error);
                }
            });
        });
    });

    function afficherAlerte(message) {
        // Créer une div pour l'alerte
        var alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert">' + message +
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

        // Ajouter l'alerte à un conteneur (par exemple, le corps du document)
        $('body').append(alertDiv);

        // Fermer l'alerte après 3 secondes
        setTimeout(function() {
            alertDiv.alert('close');
        }, 3000);
    }
    document.addEventListener("DOMContentLoaded", function () {
        // Récupérer la table et les lignes
        var table = document.getElementById("candidatsTable");
        var rows = table.getElementsByTagName("tr");

        // Récupérer l'input de recherche
        var searchInput = document.getElementById("searchInput");

        // Ajouter un gestionnaire d'événement pour le changement dans le champ de recherche
        searchInput.addEventListener("input", function () {
            var searchTerm = searchInput.value.toLowerCase();

            // Parcourir toutes les lignes de la table
            for (var i = 1; i < rows.length; i++) {
                var row = rows[i];
                var nom = row.cells[0].innerText.toLowerCase();
                var numero = row.cells[1].innerText.toLowerCase();

                // Vérifier si le terme de recherche est présent dans le nom ou le numéro
                if (nom.includes(searchTerm) || numero.includes(searchTerm)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });
</script>
<script>


   function redirectToConsultation(infoConsultationId, candidatId) {
    if (candidatId && infoConsultationId !== null) {
        // Rediriger vers le lien avec les ID
        window.location.href = `ficheConsultation/${candidatId}`;
    }
    if (infoConsultationId === null) {
        alert("Une erreur est survenue")
    }
}
</script>