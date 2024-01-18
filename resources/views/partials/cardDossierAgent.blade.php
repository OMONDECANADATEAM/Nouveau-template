@php
$users = \App\Models\User::whereNotIn('id_role_utilisateur', [0, 3])->get();

@endphp

<div class="row">
    @foreach ($users as $user)
        <div class="col-xl-4 col-sm-6 mb-xl-0 mt-4">
            <div class="card show">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">description</i>
                    </div>
                    <div class="text-end">
                        <p class="text-xl text-bold mb-0 text-capitalize">{{ $user->name }} {{ $user->last_name }} - {{ $user->succursale->label }}
                        </p>
                        <h3 class="mb-0 pt-2"></h3>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    {{-- Afficher les icônes des fichiers dans le dossier du client --}}
                    @php
                        $dossierPath = storage_path('app/public/dossierAgent/' . substr($user->name, 0, 2) . substr($user->last_name, 0, 1) . $user->id);
                        $files = glob($dossierPath . '/*');
                    @endphp

                    @if (!empty($files))
                        <div class="row">
                            <div class="col-md-6">
                                <ul style="list-style-type: none;">
                                    @foreach ($files as $index => $file)
                                        @if ($index % 2 == 0)
                                            <li>
                                                <i class="material-icons">insert_drive_file</i>
                                                <a href="{{ asset('storage/' . str_replace(storage_path('app/public'), '', $file)) }}"
                                                    target="_blank">
                                                    {{ basename($file) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <ul style="list-style-type: none;">
                                    @foreach ($files as $index => $file)
                                        @if ($index % 2 == 1)
                                            <li>
                                                <i class="material-icons">insert_drive_file</i>
                                                <a href="{{ asset('storage/' . str_replace(storage_path('app/public'), '', $file)) }}"
                                                    target="_blank">
                                                    {{ basename($file) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <p>Aucun fichier trouvé.</p>
                    @endif


                    {{-- Bouton pour ajouter un nouveau fichier --}}
                    <div class="text-left d-flex align-items-center justify-content-end">
                        <a class="btn btn-success btn-sm ml-auto" data-bs-toggle="modal"
                            data-bs-target="#ajouterFichierModal{{ $user->id }}">
                            <i class="material-icons opacity-10" style="font-size: 24px;">add</i>
                        </a>
                        <!-- Modal -->
                        <div class="modal z-index-2 fade" id="ajouterFichierModal{{ $user->id }}"
                            aria-labelledby="ajouterFichierModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ajouterFichierModalLabel">Ajouter des fichiers au
                                            dossier de {{ $user->name }} {{ $user->last_name}}   </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="ajouterFichierForm{{ $user->id }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="fichiers" class="form-label">Sélectionner des
                                                    fichiers</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control border rounded-3 p-2"
                                                        id="fichiers{{ $user->id }}" name="fichiers[]" multiple
                                                        style="height: 3rem;">
                                                    <label class="input-group-text"
                                                        for="fichiers{{ $user->id }}">Parcourir</label>
                                                </div>
                                            </div>


                                            <div class="text-end d-flex justify-content-around">
                                                <button type="button" class="btn btn-dark"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="button" class="btn btn-success w-30"
                                                    onclick="ajouterFichiers({{ $user->id }})">Ajouter</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ajoutez une nouvelle ligne après chaque troisième carte --}}
        @if ($loop->iteration % 3 == 0)
</div>
<div class="row">
    @endif
    @endforeach
</div>

<!-- Assurez-vous que vous avez inclus jQuery sur votre page -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function ajouterFichiers(userId) {
        var form = $('#ajouterFichierForm' + userId)[0];
        var formData = new FormData(form);

        $.ajax({
            type: 'POST',
            url: '/ajouter-fichiers/' + userId,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response && response.message) {
                    console.log(response.message);

                    // Fermer le modal après un ajout réussi
                    $('#ajouterFichierModal' + userId).modal('hide');

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
</script>


<!-- Style pour la classe .show et .hidden -->
<style>
    .card.show {
        display: block;
    }

    .card.hidden {
        display: none;
    }
</style>

<!-- Script pour filtrer les cartes -->
<script>
    function filterCards() {
        var searchText = document.getElementById('searchInput').value.toLowerCase();
        var cards = document.querySelectorAll('.card');

        cards.forEach(function(card) {
            card.classList.remove('show');
            card.classList.add('hidden');
        });

        var displayedCards = 0;

        cards.forEach(function(card) {
            var usereName = card.querySelector('.text-xl').innerText.toLowerCase();

            if (usereName.includes(searchText) && displayedCards < 3) {
                card.classList.remove('hidden');
                card.classList.add('show');
                displayedCards++;
            }
        });
    }

    document.getElementById('searchInput').addEventListener('input', filterCards);
</script>
