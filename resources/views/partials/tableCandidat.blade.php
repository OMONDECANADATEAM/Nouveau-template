@foreach ($data_candidat as $candidat)
<tr>
    <td>
        <div class="d-flex px-2">
            <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>
        </div>
    </td>
    <td>
        <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}</p>
    </td>
    <td>
        <span class="text-md font-weight-bold">{{ $candidat->profession }}</span>
    </td>
    <td class="align-middle text-center">

        <span class="text-md font-weight-bold">
            {{ date('Y-m-d', strtotime($candidat->date_enregistrement)) }}
        </span>

    </td>
    <td class="align-middle">
        <button class="btn btn-link text-secondary mb-0" data-bs-toggle="modal"
            data-bs-target="#modifierContactModal{{ $candidat->id }}">
            <i class="fa fa-pencil text-xs"></i> Modifier
        </button>
    </td>
    @include('partials.modifierContact', ['candidat' => $candidat])
</tr>
@endforeach


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupérez la référence de l'élément de saisie
        var searchInput = document.getElementById('searchInput');

        // Récupérez toutes les lignes du tableau
        var rows = document.querySelectorAll('table tbody tr');

        // Ajoutez un gestionnaire d'événement pour la saisie
        searchInput.addEventListener('input', function () {
            var searchText = searchInput.value.toLowerCase();

            // Parcours de chaque ligne du tableau
            rows.forEach(function (row) {
                // Récupérez le texte de chaque cellule dans la ligne
                var rowData = row.textContent.toLowerCase();

                // Affiche ou masque la ligne en fonction de la correspondance de la recherche
                if (rowData.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>