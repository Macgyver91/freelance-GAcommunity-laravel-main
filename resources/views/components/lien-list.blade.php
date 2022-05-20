@props(['participants' => $participants, 'arrayMembre' => $arrayMembre, 'membres' => $membres])
<div id="accordion2" class="w-100">
    <div class="borderP w-100">
        <div class="card-headers w-100" id="headingThree2">
            <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block" data-toggle="collapse"
                data-target="#collapseThree2" aria-expanded="false" aria-controls="collapseThree2">
                Les Liens
            </div>
        </div>
        <div id="collapseThree2" class="collapse" aria-labelledby="headingThree2" data-parent="#accordion2">
            <div class="card-body">
                <div class="borderP table-responsive">
                    <table aria-describedat="test" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Participant</th>
                                <th scope="col">Liens</th>
                                <th scope="col">Individus</th>
                                <th scope="col">Participant&nbsp;a&nbsp;cette&nbsp;evenement</th>
                                <th scope="col">Téléphone&nbsp;individus</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($participants as $parti)
                                @foreach ($membres as $membr)
                                    @if ($parti->membre->id === $membr->id)
                                        @foreach ($membr->liens as $lien)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('show_profile', $parti->membre->id) }}">
                                                        {{ json_decode($parti->membre->info)->nom }}
                                                        {{ json_decode($parti->membre->info)->prenom }}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $lien->type_lien->name }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('show_profile', $lien->prospect->id) }}">
                                                        {{ json_decode($lien->prospect->info)->nom }}
                                                        {{ json_decode($lien->prospect->info)->prenom }}
                                                    </a>
                                                </td>
                                                <td>
                                                    OUI
                                                </td>
                                                <td>{{ json_decode($parti->membre->info)->telephone }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                            style="background: #fff">
                                                            <a href="{{ route('admin.edit_link', $lien->id) }}"
                                                                class="dropdown-item">
                                                                Modifier
                                                            </a>
                                                            <form action="{{ route('delete_link', $lien) }}"
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
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
