<div class="card my-2">
    <div class="bg-gradient-dark border-radius-lg pt-4 pb-2 d-flex align-items-center justify-content-between p-4">
        <div class="p-2 border-radius-lg w-40 bg-white">
            <input type="text" id="searchInput" class="form-control text-dark text-lg bg-transparent border-0 p-1"
                placeholder="Rechercher...">
        </div>
        
        <div class="p-2 d-flex align-items-center w-30 justify-content-around flex-direction-row">
            <button class="btn bg-gradient-primary" onclick="filtrerCandidats('Consultation effectuée')">Succursale</button>
            <button class="btn bg-gradient-primary" onclick="afficherTousLesCandidats()">Type de Visa paimenent</button>
            <button class="btn bg-gradient-primary" onclick="afficherTousLesCandidats()">Voir tout</button>
        </div>
    </div>

    <div class="card-body px-0">
        <div class="table-responsive p-0" style="overflow-y: auto;">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NOM & PRENOM(S)</th>
                        <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">TYPE PAIEMENT</th>
                        <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">AGENT / SUCCURSALLE</th>
                        <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">MONTANT</th>
                        <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">DATE DE PAIEMENT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donneesCandidat as $candidat)
                        <tr data-candidat-id="{{ $candidat['id'] }}">
                            <td class="align-middle">
                                <h6 class="p-2 text-md">{{ $candidat['nom'] }} {{ $candidat['prenom'] }}</h6>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-md font-weight-bold">{{ $candidat['type_paiement'] }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-md font-weight-bold">{{ $candidat['agent_succursale'] }}</span>
                            </td>
                            <td class="align-middle text-center ">
                                <span class="text-md   font-weight-bold">
                                    {{ number_format($candidat['montant_dernier_paiement'], 0, '.', ' ') }} FCFA
                                </span>
                            </td>
                            
                            <td class="align-middle text-center">
                                <span class="text-md font-weight-bold">{{ $candidat['date_dernier_paiement'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
          
        </div>
    </div>
</div>
<div class="d-flex justify-content-center">
    {{ $donneesCandidat->onEachSide(3)->links('pagination::bootstrap-4') }}
    
</div>

<script>
$(document).ready(function() {
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>