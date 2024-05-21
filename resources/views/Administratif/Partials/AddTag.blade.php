
  
  <!-- Modal Structure -->
  <div class="modal fade z-index-1" id="changeTagModal{{ $candidat->id }}" tabindex="-1" aria-labelledby="changeTagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changeTagModalLabel">Ajouter un tag</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form to change the tag -->
          <form id="tagChangeForm" data-candidat-id="{{ $candidat->id }}">
            <div class="mb-3">
              <label for="tagSelect" class="form-label">Sélectionner un nouveau tag:</label>
              <select class="form-select" id="tagSelect">
                <!-- Options should be populated based on available tags -->
                <option selected>Choisir...</option>
                @foreach (App\Models\Tags::all() as $tag)
                <option value="{{ $tag->id }}">{{ $tag->label }}</option>
            @endforeach
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary">Sauvegarder les changements</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  

  <script>
    $(document).ready(function () {
        $('#tagChangeForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission
    
            var candidatId = $(this).data('candidat-id'); // Assuming candidatId is stored as a data attribute on the form
            var tagId = $('#tagSelect').val(); // Get the selected tag's ID
    
            $.ajax({
                url: '/Administratif/UpdateTag/' + candidatId + '/' + tagId,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for Laravel
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message); // Display success message
                        window.location.reload(); // Reload the page to reflect changes
                    } else {
                        alert(response.message); // Display error message if not successful
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error); // Alert the error if the AJAX call fails
                }
            });
        });
    });
    </script>
    

  </script>