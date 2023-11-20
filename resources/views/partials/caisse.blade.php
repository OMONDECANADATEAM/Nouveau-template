@php
    use Carbon\Carbon;

    // Obtenez le mois actuel
    $moisActuel = Carbon::now()->format('m');

    // Obtenez le total du mois en cours
    $totalCourant = \App\Models\Entree::whereMonth('date', $moisActuel)->sum('montant');

    // Obtenez le mois précédent
    $moisPrecedent = Carbon::now()->subMonth()->format('m');

    // Obtenez le total du mois précédent
    $totalMoisPrecedent = \App\Models\Entree::whereMonth('date', $moisPrecedent)->sum('montant');

    // Calculez le pourcentage d'évolution
    $pourcentageEvolution = ($totalCourant - $totalMoisPrecedent) / $totalMoisPrecedent * 100;
@endphp

<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">wallet</i>
            </div>
            <div class="text-end">
                <p class="text-xl mb-0 text-capitalize">Caisse - {{ Carbon::now()->format('F') }}</p>
                <h3 class="mb-0 pt-2">{{ $totalCourant ?? '0' }} FCFA</h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
            <p class="mb-0">
                <span class="text-success text-sm font-weight-bolder">
                    @if($pourcentageEvolution > 0)
                        +{{ number_format($pourcentageEvolution, 0) }}%
                    @elseif($pourcentageEvolution < 0)
                        {{ number_format($pourcentageEvolution, 0) }}%
                    @else
                        Aucun changement
                    @endif
                </span> par rapport au mois précédent
            </p>
        </div>
    </div>
</div>
