@props(['participants' => $participants, 'nbrMembre' => $nbrMembre, 'arrayMembre' => $arrayMembre, 'membres' => $membres, 'event' => $event])

<div id="accordion1" class="w-100">
    <div class="borderP w-100">
        <div class="card-headers w-100" id="headingThree1">
            <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block" data-toggle="collapse"
                data-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree1">
                Les participants
            </div>
        </div>
        <div id="collapseThree1" class="collapse" aria-labelledby="headingThree1" data-parent="#accordion1">
            <div class="px-4 pt-4">
                <div class="borderP table-responsive">
                    <table aria-describedby="test" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Prenom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Ange</th>
                                <th scope="col">Contrat</th>
                                <th scope="col">Mini_groupe</th>
                                <th scope="col">Staff</th>
                            </tr>
                        </thead>
                        @if ($participants->count())
                            @foreach ($participants as $participant)
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{ route('show_profile', $participant->membre->id) }}">
                                                {{ json_decode($participant->membre->info)->nom }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('show_profile', $participant->membre->id) }}">
                                                {{ json_decode($participant->membre->info)->prenom }}
                                            </a>
                                        </td>
                                        <td>{{ json_decode($participant->membre->info)->telephone }}</td>
                                        <td>
                                            <a
                                                href="{{ route('show_profile', json_decode($participant->membre->info)->ange) }}">
                                                {{ json_decode($participant->membre->info)->ange }}
                                            </a>
                                        </td>
                                        <td>{{ json_decode($participant->membre->info)->contrat }}</td>
                                        <td></td>
                                        <td></td>
                                        @can('event_management')
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-add dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                        style="background: #fff">
                                                        @can('create_abandons')
                                                            <button class="dropdown-item" data-toggle="modal"
                                                                data-target="#modalCenter"
                                                                data-id="{{ $participant->membre->id }}"
                                                                data-index-number=" {{ $participant->membre->id }}"
                                                                onclick="handleClick({{ $participant->membre->id }})">
                                                                Abandon
                                                            </button>
                                                        @endcan
                                                        <a href="{{ route('show_profile', $participant->membre->id) }}"
                                                            class="dropdown-item">
                                                            Detail
                                                        </a>

                                                        <form
                                                            action="{{ route('admin.destroy_participant', $participant) }}"
                                                            method="post" class="">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button class="dropdown-item" type="submit">
                                                                Supprimer
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>

                                            </td>
                                        @endcan
                                    </tr>
                                </tbody>
                            @endforeach
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="5">Pas de data</td>
                                </tr>
                            </tbody>
                        @endif

                    </table>

                </div>
            </div>


            <div class="px-4 py-4">
                @can('event_management')

                    <div class="title_txt">Ajouter participants a cette evenement</div>
                    <form action="{{ route('admin.add_participant') }}" method="post" class="">
                        @csrf

                        <input type="hidden" name="evenement_id" value="{{ $event->id }}">


                        <div class="form-group col-12 p-0">
                            <div>
                                <p class="mb-1">Ajouter participant</p>
                                <select class="multi-select form-control" name="states[]" multiple="multiple">
                                    @if (isset($membres))
                                        @foreach ($membres as $membre)
                                            <option value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            @error('states[]')
                                <div class="text-warning">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Ajouter
                                    participant</button>
                            </div>
                            <div class="col-12 col-md-6">
                                <a href="{{ route('admin.store_membre') }}" class="btn btn-add btn-lg w-100">Creer un
                                    membre</a>
                            </div>
                        </div>
                    </form>
                @endcan

            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="modalCenter">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adandon</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form id="myForm" action="{{ route('admin.abandon', $event) }}" method="post" enctype='application/json'>
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="membre_id" value="" id="membre_id_input" class="membre_id_input">
                    <div class="form-group col-12">
                        <div>
                            <label class="" for="motif">Motif</label>
                            <input value="{{ old('motif') }}" type="text" name="motif"
                                class="form-control @error('motif') border-warning @enderror" id="motif"
                                placeholder="Motif d'abandon">
                        </div>
                        @error('motif')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <div>
                            <label class="" for="nb_rate">Nombre d'abandon</label>
                            <input value="{{ old('nb_rate') }}" type="number" step="0.1" min="0" max="1"
                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==1) return false;"
                                name="nb_rate" class="form-control @error('nb_rate') border-warning @enderror"
                                id="nb_rate" placeholder="Nombre d'abandon">
                        </div>
                        @error('nb_rate')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
        </div>
    </div>
</div>
