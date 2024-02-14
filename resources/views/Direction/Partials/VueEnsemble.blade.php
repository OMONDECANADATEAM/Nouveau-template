<div class="row col-lg-12 d-flex align-items-center justify-content-around">
    @foreach ($donneesSuccursales as $succursaleId => $totals)
        <div class="col-xl-3 col-sm-6 mb-6 mt-4">
            <!-- Entrées -->
            <div class="card rounded-3" style="height: 8rem;">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-md icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n2 position-absolute">
                        <i class="material-icons opacity-10">wallet</i>
                    </div>
                    <div class="text-end">
                        <p class="text-lg mb-0 text-capitalize">
                            Caisse - {{ $succursaleId }}
                        </p>
                        <h3 class="mb-0 pt-1 text-bold">{{ number_format($totals['totalEntrant'], 0, '.', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>
    
            <!-- Dépenses -->
            <div class="card rounded-3 mt-3" style="height: 8rem;">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-md icon-shape bg-gradient-danger shadow-dark text-center border-radius-xl mt-n2 position-absolute">
                        <i class="material-icons opacity-10">money_off</i>
                    </div>
                    <div class="text-end">
                        <p class="text-lg mb-0 text-capitalize">
                            Dépenses - {{ $succursaleId }}
                        </p>
                        <h3 class="mb-0 pt-2 text-bold">{{ number_format($totals['totalDepenses'], 0, '.', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
 