<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3">
                <div
                    class="bg-gradient-dark shadow-primary border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
                    <div class="p-2 border-radius-lg w-100 d-flex flex-direction-row justify-content-between ">
                        <h3 class="text-white">
                            Rendez-vous du jour
                        </h3>

                        <a href="{{ route('Commercial.RendezVous') }}" class="btn btn-primary">
                            Voir tout
                        </a>
                    </div>
                </div>

                <div class="card-body px-0 pb-2 ">
                    <div class="table-responsive p-0  " style="max-height: 750px; overflow-y: auto;">
                        <table class="table align-items-center justify-content-between mb-0 bg-white">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-left text-secondary text-xxs font-weight-bolder opacity-7">
                                        NOM
                                    </th>
                                    <th
                                        class="text-uppercase  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        NUMERO
                                    </th>
                                    <th
                                        class="text-uppercase  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        PROFFESSION
                                    </th>
                                    <th
                                        class="text-uppercase  text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        RENDEZ VOUS EFFECTUE
                                    </th>
                                    <th
                                        class="text-uppercase text-center  text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        CONSULTATION PAYEE
                                    </th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($rendezVous as $candidat)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}
                                                </h6>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-md font-weight-bold mb-0">{{ $candidat->numero_telephone }}
                                            </p>
                                        </td>
                                        <td>
                                            <span class="text-md font-weight-bold">{{ $candidat->profession }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-around">
                                                @if ($candidat->rendezVous && $candidat->rendezVous->rdv_effectue === 0)
                                                    <button
                                                        onclick="toggleStatutRendezVous('{{ $candidat->rendezVous->id }}', 'yes');"
                                                        data-candidat-id="{{ $candidat->id }}" class="btn btn-primary">
                                                        <i class="material-icons text-bolder icon-large toggle-consultation"
                                                            style="font-size: 2rem;">check</i>
                                                    </button>

                                                    <button
                                                        onclick="toggleStatutRendezVous('{{ $candidat->rendezVous->id }}', 'no');"
                                                        data-candidat-id="{{ $candidat->id }}" class="btn btn-primary">
                                                        <i class="material-icons text-bolder icon-large toggle-consultation"
                                                            style="font-size: 2rem;">close</i>
                                                    </button>
                                                @elseif ($candidat->rendezVous && $candidat->rendezVous->rdv_effectue === 1)
                                                    <i class="material-icons text-success text-bolder icon-large"
                                                        style="font-size: 2rem;">check</i>
                                                @endif

                                            </div>

                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-around ">
                                                @if ($candidat->rendezVous && $candidat->rendezVous->consultation_payee === 0)
                                                    <button
                                                        onclick="toggleConsultationPayee('{{ $candidat->rendezVous->id }}', 'yes');"
                                                        data-candidat-id="{{ $candidat->id }}" class="btn btn-primary">
                                                        <i class="material-icons text-bolder icon-large toggle-consultation"
                                                            style="font-size: 2rem;">check</i>
                                                    </button>

                                                    <button
                                                        onclick="toggleConsultationPayee('{{ $candidat->rendezVous->id }}', 'no');"
                                                        data-candidat-id="{{ $candidat->id }}" class="btn btn-primary">
                                                        <i class="material-icons text-bolder icon-large toggle-consultation"
                                                            style="font-size: 2rem;">close</i>
                                                    </button>
                                                @elseif ($candidat->rendezVous && $candidat->rendezVous->consultation_payee === 1)
                                                    <i class="material-icons text-success text-bolder icon-large"
                                                        style="font-size: 2rem;">check</i>
                                                @endif

                                            </div>

                                        </td>

                                      


                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>



            </div>
        </div>
    </div>
