<div class="row d-flex flex-direction-column align-items-center justify-content-around">

   

    {{-- Affiche les entrees du mois --}}
    <div class="row mb-6 mt-4 p-4">

       <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card" data-succursale-id="">
                    <div class="card-header1 p-3 pt-2 d-flex justify-content-between">
                        <div
                            class="icon icon-md icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4">
                            <i class="material-icons opacity-10">arrow_upward</i>
                        </div>
                        <p class="text-xl text-bold mb-0 text-capitalize">PAYS</p>
                    </div>
                    <div class="card-body">
                        <div class="text-end">
                            <h3 class="mb-0 pt-2">montant</h3>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <div class="progress mt-2">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                style="width: {{ (100 / 100) * 100 }}%; ; height:100%;"
                                aria-valuenow="{{ 40 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header1 p-3 pt-2 d-flex justify-content-between">
                        <div
                            class="icon icon-md icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4">
                            <i class="material-icons opacity-10">arrow_downward</i>
                        </div>
                        <p class="text-xl text-bold mb-0 text-capitalize">Depenses - Pays</p>
    
                    </div>
                    <div class="card-body">
                        <div class="text-end">
    
                            <h3 class="mb-0 pt-2">MONTANT</h3>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <div class="progress mt-2">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                style="width: {{ (100 / 100) * 100 }}%; ; height:100%;" aria-valuenow="{{ 40 }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
    
                    </div>
    
                </div>
            </div>
    
    
            {{-- Affiche la caisse du mois --}}
    
            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header1 p-3 pt-2 d-flex justify-content-between">
                        <div
                            class="icon icon-md icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4">
                            <i class="material-icons opacity-10">account_balance_wallet</i>
                        </div>
                        <p class="text-xl text-bold mb-0 text-capitalize">Caisse - Pays</p>
    
                    </div>
                    <div class="card-body">
                        <div class="text-end">
    
                            <h3 class="mb-0 pt-2">MONTANT</h3>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        <div class="progress mt-2">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                style="width: {{ (100 / 100) * 100 }}%; ; height:100%;"
                                aria-valuenow="{{ 40 }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
    
                    </div>
    
                </div>
            </div>
        

        <div class="d-flex flex-row flex-wrap align-items-center justify-content-around mt-4">
            @foreach (App\Models\Succursale::all() as $succursale)
                <div class="form-check mr-3">
                    <input class="form-check-input" type="checkbox" value="{{ $succursale->id }}" id="succursaleCheck{{ $succursale->id }}">
                    <label class="form-check-label" for="succursaleCheck{{ $succursale->id }}">
                        {{ $succursale->label }}
                    </label>
                </div>
            @endforeach
        </div>

        

       
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    var allData; // Variable pour stocker toutes les données de succursale

    // Faites une requête AJAX à votre serveur pour obtenir les données de succursale
    $.ajax({
        url: '/Direction/Dashboard/DataSuccursale', // Remplacez ceci par l'URL de votre fonction dataSuccursale
        method: 'GET',
        success: function(data) {
            allData = data; // Stockez toutes les données pour une utilisation ultérieure

            // Mettez à jour l'interface avec les données de la première succursale
            updateInterface(data[0]);
        },
        error: function(error) {
            console.log(error);
        }
    });

    // Lorsqu'une case à cocher est modifiée
    $('.form-check-input').change(function() {
        var selectedIds = $('.form-check-input:checked').map(function() {
            return $(this).attr('id');
        }).get();

        var selectedData = allData.filter(function(data) {
            return selectedIds.indexOf(data.id) !== -1;
        });

        if (selectedData.length === 0) {
    // Aucune case à cocher sélectionnée, vous pouvez choisir de réinitialiser l'interface ou de ne rien faire
} else {
    var totalData = {
        id: '',
        label: '',
        totalEntrant: 0,
        totalDepenses: 0,
        totalCaisse: 0,
        devise: selectedData[0].devise // Supposons que toutes les succursales utilisent la même devise
    };

    selectedData.forEach(function(data) {
        totalData.totalEntrant += data.totalEntrant;
        totalData.totalDepenses += data.totalDepenses;
        totalData.totalCaisse += data.totalCaisse;
    });

    updateInterface(totalData);
}
  });

    function updateInterface(data) {
    // Mettez à jour l'ID de la succursale
    $('.card[data-succursale-id]').attr('data-succursale-id', data.id);

    // Mettez à jour le label de la succursale
    $('.card-header1 .text-xl').each(function(index) {
        if(index == 0) {
            $(this).text(data.label); // Entrées
        } else if(index == 1) {
            $(this).text('Depenses - ' + data.label); // Dépenses
        } else if(index == 2) {
            $(this).text('Caisse - ' + data.label); // Caisse
        }
    });

    // Mettez à jour le montant des entrées, dépenses et caisse
    $('.card-body h3').each(function(index) {
        if(index == 0) {
            $(this).text(data.totalEntrant + ' ' + data.devise); // Entrées
        } else if(index == 1) {
            $(this).text(data.totalDepenses + ' ' + data.devise); // Dépenses
        } else if(index == 2) {
            $(this).text(data.totalCaisse + ' ' + data.devise); // Caisse
        }
    });

    // Mettez à jour les progress bars
    $('.progress-bar').each(function(index) {
        var percentage = 0;
        if(index == 0) {
            percentage = (data.totalEntrant / data.totalCaisse) * 100; // Entrées
        } else if(index == 1) {
            percentage = (data.totalDepenses / data.totalCaisse) * 100; // Dépenses
        } else if(index == 2) {
            percentage = (data.totalCaisse / data.totalCaisse) * 100; // Caisse
        }
        $(this).css('width', percentage + '%');
        $(this).attr('aria-valuenow', percentage);
    });
}

});

    </script>
    