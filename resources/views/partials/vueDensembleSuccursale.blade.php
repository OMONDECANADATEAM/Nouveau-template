<div class="row col-lg-12 d-flex align-items-center justify-content-around">
    @php
        use Carbon\Carbon;

        // Obtenez le mois actuel
        $moisActuel = Carbon::now()->format('m');
        
        // Obtenez la liste des succursales
        $succursales = \App\Models\Succursale::all();
    @endphp

    @foreach ($succursales as $succursale)
        @php
            // Obtenez le total du mois en cours pour la succursale actuelle (entrées)
            $totalEntrant = \App\Models\Entree::whereMonth('date', $moisActuel)
                ->whereHas('utilisateur', function ($query) use ($succursale) {
                    $query->where('id_succursale', $succursale->id);
                })
                ->sum('montant');

            // Obtenez le total du mois en cours pour les dépenses de la succursale actuelle
            $totalDepenses = \App\Models\Depense::whereMonth('date', $moisActuel)
                ->whereHas('utilisateur', function ($query) use ($succursale) {
                    $query->where('id_succursale', $succursale->id);
                })
                ->sum('montant');
        @endphp

        <div class="col-xl-3 col-sm-6 mb-4">
            <!-- Entrées -->
            <div class="card rounded-3" style="height: 8rem;">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-md icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">wallet</i>
                    </div>
                    <div class="text-end">
                        <p class="text-xl mb-0 text-capitalize">
                            Caisse - {{ $succursale->label }} - {{ Carbon::now()->format('F') }}
                        </p>
                        <h3 class="mb-0 pt-2">{{ number_format($totalEntrant, 0, '.', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>

            <!-- Dépenses -->
            <div class="card rounded-3 mt-3" style="height: 8rem;">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-md icon-shape bg-gradient-danger shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">money_off</i>
                    </div>
                    <div class="text-end">
                        <p class="text-xl mb-0 text-capitalize">
                            Dépenses - {{ $succursale->label }} - {{ Carbon::now()->format('F') }}
                        </p>
                        <h3 class="mb-0 pt-2">{{ number_format($totalDepenses, 0, '.', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
