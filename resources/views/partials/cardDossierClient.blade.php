@php
    $candidatsVersementEffectue = App\Models\Candidat::where('versement_effectuee', true)->get();
@endphp

<style>
    .card.show {
    display: block;
}

.card.hidden {
    display: none;
}
</style>
<div class="row">
    @foreach($candidatsVersementEffectue as $candidat)
        <div class="col-xl-4 col-sm-6 mb-xl-0 mt-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">description</i>
                    </div>
                    <div class="text-end">
                        <p class="text-xl text-bold mb-0 text-capitalize">{{ $candidat->nom }} {{ $candidat->prenom }}</p>
                        <h3 class="mb-0 pt-2"></h3>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    

                    {{-- Afficher les icônes des fichiers dans le dossier du client --}}
                    @php
                    $dossierPath = storage_path('app/public/dossierClient/' . substr($candidat->nom, 0, 2) . substr($candidat->prenom, 0, 1) . $candidat->id);
                    $files = glob($dossierPath . '/*');
                @endphp
                
                @if (!empty($files))
                    <ul>
                        @foreach ($files as $file)
                            <li>
                                <i class="material-icons mr-1">insert_drive_file</i>
                                <a href="{{ asset('storage/' . str_replace(storage_path('app/public'), '', $file)) }}" target="_blank">
                                    {{ basename($file) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Aucun fichier trouvé.</p>
                @endif
                

                    {{-- Bouton pour ajouter un nouveau fichier --}}
                    <div class="text-left  d-flex align-items-center justify-content-around">
                        <p class="mb-0">
                            Ici on doit avoir une barre pour l'évolution
                        </p>
                        
                        {{-- href="{{ route('ajouterDossier', ['candidatId' => $candidat->id]) }}" --}}
                        <a  class="btn btn-success btn-sm">
                            <i class="material-icons opacity-10" style="font-size: 24px;">
                                add
                            </i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>

        {{-- Ajoutez une nouvelle ligne après chaque quatrième carte --}}
        @if($loop->iteration % 3 == 0)
            </div><div class="row">
        @endif
    @endforeach
</div>


<!-- Ajoutez ce script à l'endroit où vous chargez vos scripts JavaScript, avant la balise de fermeture du corps </body> -->
<script>
    // Fonction pour filtrer les cartes en fonction du texte de recherche
    function filterCards() {
    // Récupérer la valeur saisie dans l'input de recherche
    var searchText = document.getElementById('searchInput').value.toLowerCase();

    // Récupérer toutes les cartes
    var cards = document.querySelectorAll('.card');

    // Réinitialiser la classe pour toutes les cartes
    cards.forEach(function(card) {
        card.classList.remove('show');
        card.classList.add('hidden');
    });

    // Compter le nombre de cartes affichées
    var displayedCards = 0;

    // Parcourir toutes les cartes
    cards.forEach(function(card) {
        // Récupérer le nom du candidat dans la carte
        var candidateName = card.querySelector('.text-xl').innerText.toLowerCase();

        // Afficher ou masquer la carte en fonction de la correspondance avec le texte de recherche
        if (candidateName.includes(searchText) && displayedCards < 3) {
            card.classList.remove('hidden');
            card.classList.add('show');
            displayedCards++;
        }
    });
}

// Ajouter un gestionnaire d'événement pour déclencher la fonction de filtrage lors de la saisie dans l'input de recherche
document.getElementById('searchInput').addEventListener('input', filterCards);


    // Ajouter un gestionnaire d'événement pour déclencher la fonction de filtrage lors de la saisie dans l'input de recherche
    document.getElementById('searchInput').addEventListener('input', filterCards);
</script>
