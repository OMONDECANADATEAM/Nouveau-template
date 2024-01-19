<div class="row">
    <div class="col-md-12 mt-6">
        <div class="card h-100 mb-4">
            <div class="card-header pb-0 px-3">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">TRANSACTIONS</h6>
                    </div>
                    <div
                        class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                        <i class="material-icons me-2 text-lg">date_range</i>
                        <small>{{ $dateDebutSemaine->format('d F') }} -
                            {{ $dateFinSemaine->format('d F') }}</small>

                    </div>
                </div>
            </div>
            @php
             use Carbon\Carbon;
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();

                $depenses = \App\Models\Depense::whereBetween('date', [$startOfWeek, $endOfWeek])->get();
                $entrees = \App\Models\Entree::whereBetween('date', [$startOfWeek, $endOfWeek])->get();

                // Organiser les dépenses par jour
                $depensesParJour = [];
                foreach ($depenses as $depense) {
                    $jour = Carbon::parse($depense->date)->format('l');
                    // 'l' donne le nom du jour de la semaine
                    $depensesParJour[$jour][] = $depense;
                }

                // Organiser les entrées par jour
                $entreesParJour = [];
                foreach ($entrees as $entree) {
                    $jour = Carbon::parse($entree->date)->format('l');
                    $entreesParJour[$jour][] = $entree;
                }
            @endphp
            <div class="card-body pt-4 p-3">
                <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Cette semaine</h6>

                @foreach (array_reverse(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) as $jour)
                    @if (isset($depensesParJour[$jour]) || isset($entreesParJour[$jour]))
                        <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                            {{ $jour }}</h6>
                        <ul class="list-group">
                            @foreach ($depensesParJour[$jour] ?? [] as $depense)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <button
                                            class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="material-icons text-lg">expand_more</i>
                                        </button>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $depense->raison }}</h6>
                                            <span class="text-xs">{{ $depense->date }}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                        {{ number_format(abs($depense->montant), 0, ',', ' ') }}
                                        FCFA
                                    </div>
                                </li>
                            @endforeach

                            @foreach ($entreesParJour[$jour] ?? [] as $entree)
                                <li
                                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <button
                                            class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center">
                                            <i class="material-icons text-lg">expand_less</i>
                                        </button>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">
                                                @php
                                                    $label = \App\Models\TypePaiement::where('id', $entree->id_type_paiement)->value('label');
                                                @endphp
                                                {{ $label }}
                                            </h6>
                                            <span class="text-xs">{{ $entree->date }}</span>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                        {{ number_format($entree->montant, 0, ',', ' ') }}
                                        FCFA
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
       </div>
    </div>
</div>