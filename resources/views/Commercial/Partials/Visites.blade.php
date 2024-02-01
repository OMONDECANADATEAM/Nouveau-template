{{-- Affiche du nombre de rendez-vous conclus du mois --}}

<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2 d-flex justify-content-between">
            <div class="icon icon-md icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 ">
                <i class="material-icons opacity-10">groups</i>
            </div>
            <p class="text-xl text-bold mb-0 text-capitalize">Rendez-Vous Conclus - {{ $moisActuel }}</p>
        </div>
        
        <div class="card-body">
            <div class="text-end">
                <h3 class="mb-0 pt-2">{{ $totalVisiteMois ?? '0' }}</h3>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
            {{-- Barre de progression --}}
            <div class="progress mt-2">
                <div class="progress-bar progress-bar-striped bg-dark" role="progressbar" style="width: {{ ($totalVisiteMois / 25) * 100 }}%;" aria-valuenow="{{ $totalVisiteMois }}" aria-valuemin="0" aria-valuemax="25"></div>
            </div>
        </div>
    </div>
</div>
