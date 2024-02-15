<!-- Modal pour afficher les détails du dossier -->
<div class="modal fade z-index-2" id="voirDossierModal{{ $user->id }}" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Documents de {{ $user->name }} {{ $user->last_name }}</h5>
            </div>
            <div class="modal-body">
                @php
                    $dossierPath = storage_path('app/public/dossierAgent/' . substr($user->name, 0, 2) . substr($user->last_name, 0, 1) . $user->id);
                    $files = glob($dossierPath . '/*');
                @endphp

                @if (!empty($files))
                    <div class="row">
                        <div class="col-md-6">
                            <ul style="list-style-type: none;">
                                @foreach ($files as $file)
                                    <li>
                                        <i class="material-icons">insert_drive_file</i>
                                        <a href="{{ asset('storage/' . str_replace(storage_path('app/public'), '', $file)) }}"
                                            target="_blank">
                                            {{ basename($file) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @else
                    <p>Aucun fichier trouvé.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
