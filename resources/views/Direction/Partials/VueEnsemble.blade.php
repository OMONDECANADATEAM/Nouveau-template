<div class="row col-lg-12 d-flex align-items-center justify-content-around">
    @foreach ($donneesSuccursales as $succursaleId => $totals)
        <div class="col-xl-3 col-sm-6 mb-6 mt-4">
            <!-- Entrées -->
            <div class="card rounded-3" style="height: 8rem;">
                <div class="card-header p-2 pt-0">
                    <div class="icon icon-md icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n2 position-absolute">
                        <i class="material-icons opacity-10">wallet</i>
                    </div>
                    <div class="text-end">
                        <p class="text-md mb-0 text-capitalize text-bold">
                            Caisse - {{ $succursaleId }}
                        </p>
                        <h3 class="mb-0 pt-3 text-bold">{{ number_format($totals['totalEntrant'], 0, '.', ' ') }} {{ $totals['devise']}}</h4>
                    </div>
                </div>
            </div>
    
            <!-- Dépenses -->
            <div class="card rounded-3 mt-3" style="height: 8rem;">
                <div class="card-header p-2 pt-0">
                    <div class="icon icon-md icon-shape bg-gradient-danger shadow-dark text-center border-radius-xl mt-n2 position-absolute">
                        <i class="material-icons opacity-10">money_off</i>
                    </div>
                    <div class="text-end">
                        <p class="text-md mb-0 text-capitalize text-bold">
                            Dépenses - {{ $succursaleId }}
                        </p>
                        <h3 class="mb-0 pt-3 text-bold">{{ number_format($totals['totalDepenses'], 0, '.', ' ') }} {{ $totals['devise']}} </h4>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
 