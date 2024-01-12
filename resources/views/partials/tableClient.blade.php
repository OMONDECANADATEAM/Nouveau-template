
<div class="card my-4">
    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <h4 class="text-white text-capitalize ps-3">Dossier Client</h4>
        </div>
    </div>
    <div class="card-body px-0 pb-2">
        <div class="table-responsive p-0" style="max-height: 750px; overflow-y: auto;">
            <table class="table align-items-center justify-content-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            NOM
                        </th>
                      
                        <th
                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                            TYPE VISA
                         </th>

                         <th
                         class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                         VOIR DOSSIER
                        </th>

                        <th
                         class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                         AJOUTER DOCUMENT
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_client->sortByDesc('date') as $candidat)
                    <tr>
                        <td>
                            <div class="d-flex px-2">
                                <h6 class="p-2 text-md">{{ $candidat->nom }} {{ $candidat->prenom }}</h6>
                            </div>
                        </td>
                       
                        <td class="align-middle text-center">
                
                            <span class="text-md font-weight-bold">
                                @if($candidat->proceduresDemandees->isNotEmpty())
                                    @foreach($candidat->proceduresDemandees as $procedure)
                                        {{ $procedure->typeProcedure->label }}
                                        {{-- Vous pouvez ajouter une virgule ou un autre séparateur ici s'il y a plusieurs procédures --}}
                                    @endforeach
                                @else
                                    Sans objet
                                @endif
                            </span>
                            
                                    </td>
                        
                        <td class="align-middle text-center">

                            <button class="btn bg-gradient-dark">
                                Voir Le Dossier
                            </button>
                        </td>

                        <td class="align-middle text-center">

                            <button class="btn bg-gradient-success">
                                <i class="material-icons">add</i>
                            </button>
                        </td>
                        
                
                    </tr>
                @endforeach
                
                
                </tbody>
            </table>
            
        </div>
    </div>
   
</div>