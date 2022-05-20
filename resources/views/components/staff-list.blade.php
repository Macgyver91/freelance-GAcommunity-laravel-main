@props(['staffmembres' => $staffmembres, 'staffParticipe' => $staffParticipe, 'membres' => $membres, 'staffs' => $staffs, 'event' => $event])
<div id="accordion3" class="w-100">
    <div class="borderP w-100">
        <div class="card-headers w-100" id="headingThree3">
            <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block" data-toggle="collapse"
                data-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                Les staffs
            </div>
        </div>
        <div id="collapseThree3" class="collapse" aria-labelledby="headingThree2" data-parent="#accordion3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <div class="checList">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Orga
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Staff
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Vol
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    Service
                                </label>
                            </div>

                        </div>

                    </div>
                    <div class="col-12 col-md-10">
                        <div class=" p-2 d-flex justify-content-between">
                            <h4 class="_textN">Groupe de staff pour cet evenement</h4>
                            <a href="{{ route('admin.show_create_staff') }}" class="btn btn-add">Créer un groupe de
                                staff</a>
                        </div>
                        <div class="borderP table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">Mantra</th>
                                        <th scope="col">Nom</th>
                                    </tr>
                                </thead>
                                @if (isset($staffParticipe))
                                    <tbody>
                                        <tr>
                                            <td>{{ $staffParticipe->type }}</td>
                                            <td>{{ $staffParticipe->mantra }}</td>
                                            <td>{{ $staffParticipe->nom }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-danger dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                        style="background: #fff">

                                                        @can('edit_staffs')
                                                            <a href="{{ route('admin.show_edit_staff', $staffParticipe->id) }}"
                                                                class="dropdown-item">
                                                                Modifier
                                                            </a>
                                                        @endcan

                                                        @can('delete_staffs')
                                                            <form
                                                                action="{{ route('admin.destroy_staff', $staffParticipe) }}"
                                                                method="post" class="">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button class="dropdown-item" type="submit">
                                                                    Supprimer
                                                                </button>
                                                            </form>
                                                        @endcan

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>

                                    </tbody>
                                @else
                                    <tbody>
                                        <tr>
                                            <td colspan="6">
                                                Aucun groupe de staff dans cet evenement
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        @if (!isset($staffParticipe))
                            @can('event_management')
                                <div class="py-4">
                                    <div class="title_txt">Ajouter de staff à cet évènement</div>

                                    <form action="{{ route('admin.store_staff_event', $event) }}" method="post"
                                        class="">
                                        @csrf


                                        <div class="form-group col-12 p-0">

                                            <div>
                                                <p class="mb-1">Ajouter un groupe de staff à cet évènement</p>
                                                <select class="form-control" name="staff_id"
                                                    onchange="if(this.selectedIndex === 1) window.location.href='/admins/staffs/create';">
                                                    <option value="">
                                                        Selectionner ou Créer un groupe de staff
                                                    </option>
                                                    <option value="">
                                                        Créer un groupe de staff
                                                    </option>
                                                    @foreach ($staffs as $staff)
                                                        <option value="{{ $staff->id }}">{{ $staff->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('staff_id')
                                                <div class="text-warning">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Ajouter groupe de
                                            staff</button>
                                    </form>
                                </div>
                            @endcan
                        @endif
                        <div class="pt-4">
                            {{-- List des membres dans une staff --}}
                            <div class=" p-2 d-flex justify-content-between">
                                <h4 class="_textN">Liste des membres du staff</h4>
                                @if (isset($staffParticipe))
                                    <a href="{{ route('admin.show_staff', $staffParticipe->id) }}"
                                        class="btn btn-add">Ajout membre à cette staff</a>
                                @endif
                            </div>
                            <div class="borderP table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Prénom</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Téléphone</th>
                                            <th scope="col">Taux&nbsp;de&nbsp;assage</th>
                                        </tr>
                                    </thead>
                                    @if (isset($staffParticipe))
                                        @foreach ($staffParticipe->staff_membres as $staff_membre)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $staff_membre->role_du_staff }}</td>
                                                    <td>{{ $staff_membre->role_du_staff }}</td>
                                                    <td>
                                                        <a
                                                            href="{{ route('show_profile', $staff_membre->membre->id) }}">
                                                            {{ json_decode($staff_membre->membre->info)->prenom }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('show_profile', $staff_membre->membre->id) }}">
                                                            {{ json_decode($staff_membre->membre->info)->nom }}
                                                        </a>
                                                    </td>
                                                    <td>{{ json_decode($staff_membre->membre->info)->telephone }}
                                                    </td>
                                                    <td>{{ $staff_membre->taux_de_passage }}%</td>
                                                    @can('event_management')
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-add dropdown-toggle" type="button"
                                                                    id="dropdownMenu2" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                                    style="background: #fff">
                                                                    <form
                                                                        action="{{ route('admin.destroy_membre_staff', $staff_membre) }}"
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
                                                <td colspan="6">
                                                    Aucun staff dans cet evenement
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endif

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="modalCenter1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Staff membre</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <form id="myForm" {{-- action="{{ route('admins.store_staff_membre', $staffList) }}" --}} method="post" enctype='application/json'>
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="membre_id" value="" id="membre_id_input" class="membre_id_input">
                    <div class="form-group col-12">
                        <label class="" for="membre_id">Membre</label>
                        <select id="membre_id" name="membre_id"
                            class="form-control @error('membre_id') border-warning
                        @enderror">
                            <option value="">Selectionnez une membre</option>
                            @foreach ($membres as $membre)
                                <option value="{{ $membre->id }}">
                                    {{ json_decode($membre->info)->nom }}
                                    {{ json_decode($membre->info)->prenom }}
                                </option>
                            @endforeach
                        </select>

                        @error('membre_id')
                            <div class="text-warning">
                                Le champs membre_id est obligatoire
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <div>
                            <label class="" for="commentaire">Commentaire</label>
                            <input value="{{ old('commentaire') }}" type="text" name="commentaire"
                                class="form-control @error('commentaire') border-warning @enderror" id="motif"
                                placeholder="Commentaire du membre">
                        </div>
                        @error('commentaire')
                            <div class="text-warning">
                                Le champs commentaire est obligatoire
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <div>
                            <label class="" for="taux_de_passage">Taux de passage (%)</label>
                            <input value="{{ old('taux_de_passage') }}" type="text" name="taux_de_passage"
                                class="form-control @error('taux_de_passage') border-warning @enderror"
                                id="taux_de_passage" placeholder="Taux de passage (%)">
                        </div>
                        @error('taux_de_passage')
                            <div class="text-warning">
                                Le champs taux de passage est obligatoire
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <div>
                            <label class="" for="role_du_staff">Role du staff</label>
                            <input value="{{ old('role_du_staff') }}" type="text" name="role_du_staff"
                                class="form-control @error('role_du_staff') border-warning @enderror" id="role_du_staff"
                                placeholder="Role du staff">
                        </div>
                        @error('role_du_staff')
                            <div class="text-warning">
                                Le champs Role du staff est obligatoire
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
