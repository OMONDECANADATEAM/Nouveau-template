
    
    <div class="modal z-1 fade" id="addContactModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter un contact</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    <form action="" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control">
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
