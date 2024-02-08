<!-- Modal pour afficher les détails du dossier -->
<div class="modal fade z-index-2" id="voirDossierModal{{ $candidat->id }}" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Documents de {{ $candidat->nom }} {{ $candidat->prenom }}</h5>
            </div>
            <div class="modal-body">
                @if ($candidat->dossier && $candidat->dossier->documents->isNotEmpty())
                {{-- Le dossier a des documents --}}
                <ul>
                    @foreach ($candidat->dossier->documents as $document)
                        <li class="d-flex align-items-center">
                            <a href="{{ $document->url }}" target="_blank">
                                {{ $document->nom }}
                            </a>
                            <i class="material-icons">file_present</i>  
                        </li>
                    @endforeach
                </ul>
            @else
                {{-- Le dossier est null ou n'a pas de documents --}}
                <p>Aucun fichier trouvé.</p>
            @endif
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
