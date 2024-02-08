
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3">
        <div
            class="bg-gradient-dark border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between p-4">
            <div class="p-2 border-radius-lg w-40 bg-white">
                <input type="text " id="searchInput"
                    class="form-control text-dark  text-lg bg-transparent border-0 p-1"
                    placeholder="Recherche...">
                    
            </div>
            <button class="btn bg-primary text-white circle" data-bs-toggle="modal"
            data-bs-target="#ajouterEntreeModal">
            <i class="material-icons">add</i> Ajouter un paiement
          
        </button>
        @include('Administratif.Partials.AddEntree')
        </div>

        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0" style="min-height: 700px; max-height: 700px; overflow-y: auto;">
                <table class="table align-items-center justify-content-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                NOM
                            </th>
    
                            <th
                                class="text-uppercase text-secondary  text-xxs font-weight-bolder text-left opacity-7 ps-2">
                                MONTANT
                            </th>
    
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                TYPES DE PAIEMENT
                            </th>
    
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                DATE DE PAIMENT
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr>
                                <td>
                                    <div class="d-flex px-2">
                                        <h5 class="p-2 text-md">{{ $entry->candidat->nom }}
                                            {{ $entry->candidat->prenom }}</h5>
                                    </div>
                                </td>
                                
                                <td>
                                    <p class="text-md text-success font-weight-bold mb-0">
                                        {{ number_format($entry->montant, 0, ',', ' ') }} FCFA </p>
                                </td>
                                <td class="align-middle text-center text-xl ">
                                    
                                        {{ $entry->typePaiement->label }}
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="me-2 text-md font-weight-bold">{{ date('Y-m-d', strtotime($entry->date)) }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
        </div>


      

    </div>
</div>

