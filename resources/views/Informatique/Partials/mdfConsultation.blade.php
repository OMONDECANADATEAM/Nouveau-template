<div class="modal z-index-1 fade consultation" id="mdfConsultation{{$consultation->id}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier Consultation</h5>
          </div>
            <div class="modal-body">
                <form action="{{ route('modifierConsultation', ['id' => $consultation->id]) }}" method="POST" class="text-start" id="consultationForm{{$consultation->id}}">
                    @csrf
                    @method('PUT')
                  

                    <div class=" mb-3 p-2">
                        <label for="lien_zoom" class="form-label">Lien Zoom</label>
                        <input type="text" name="lien_zoom" id="lien_zoom" class="form-control" value="{{$consultation->lien_zoom}}" required>
                    </div>

                    <div class="mb-3 p-2">
                        <label for="lien_zoom_demarrer" class="form-label">Lien démarrer</label>
                        <input type="text" name="lien_zoom_demarrer" id="lien_zoom_demarrer" class="form-control"
                        value="{{$consultation->lien_zoom_demarrer}}" required>
                    </div>

                   <div class="row p-3">  
                    <div class="col-4 mb-3 p-2">
                        <label for="date_heure" class="form-label">Date et Heure</label>
                        <input type="datetime-local" name="date_heure" id="date_heure" class="form-control" 
                        value="{{$consultation->date_heure}}"
                        required>
                    </div>

                    <div class="col-4 mb-3 p-2">
                        <label for="nombre_candidats" class="form-label">Nombre de participants</label>
                        <input type="tel" name="nombre_candidats" id="nombre_candidats" class="form-control"
                           value="{{$consultation->nombre_candidats}}" required>
                    </div>

                    <div class="col-3 mb-3 p-2 h-25">
                        <label for="id_consultante" class="form-label">Consultante</label>
                        <select name="id_consultante" id="id_consultante" class="form-select p-2" placeholder="" required>
                            @foreach ($data_consultante as $consultante)
                                <option value="{{ $consultante->id }}">{{ $consultante->nom }}
                                    {{ $consultante->prenoms }}</option>
                            @endforeach
                        </select>
                    </div>
                   </div>

                 
                   <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-40 my-4 mb-2"
                        id="submitFormButton"  >AJOUTER</button>
                    <div id="success-message" class="alert alert-success" style="display: none;">
                        L'enregistrement a été effectué avec succès!
                    </div>
                    <div class="alert alert-danger" style="display: none;"></div>
                </div>


                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
