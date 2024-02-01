{{-- Affiche les objectifs du mois --}}

<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2 d-flex justify-content-between">
            <div class="icon icon-md icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4">
                <i class="material-icons opacity-10">handshake</i>
            </div>
            <p class="text-xl text-bold mb-0 text-capitalize">Consultations - {{ $moisActuel }}</p>

        </div>
        <div class="card-body">
            <div class="text-end">
              
                <h3 class="mb-0 pt-2">{{  $totalConsultationsDeCeMois ?? '0' }}</h3>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
            <div class="progress mt-2">
                <div class="progress-bar progress-bar-striped bg-dark" role="progressbar" style="width: {{ ($totalConsultationsDeCeMois / 15) * 100 }}%;" aria-valuenow="{{$totalConsultationsDeCeMois }}" aria-valuemin="0" aria-valuemax="15"></div>
            </div>
            
        </div>
        
    </div>
</div>
