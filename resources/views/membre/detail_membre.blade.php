@extends('layouts.app')
@section('content')
    <div class="card pt-2">
        <div class="card-header">
            <h3 class="text-center text-success"> Détail du membre</h3>
            <button onclick="printPdf()" class="btn btnAdd">Export
                PDF</button>
        </div>
        <div class="card-content p-4 print-container" id="_div">
            <div class="title_txt">Information de <span class="text-primary">{{ $membre->nom }}
                    {{ json_decode($membre->info)->prenom }}</span></div>
            <div class="p-3">
                <div class="row borderP">
                    <div class="col-12 col-md-6">

                        <div class="profile  p-2 rounded">
                            <div class="d-flex">
                                <h6 class="_txtN mr-2">
                                    <span class="_textN">{{ json_decode($membre->info)->prenom }}</span>
                                    <span class="text-uppercase _textN">{{ json_decode($membre->info)->nom }}</span>
                                </h6>
                                <h6 class="_txtN">
                                    <span class="_textN mr-2">{{ json_decode($membre->info)->genre }}</span>
                                </h6>
                                <h6 class="_txtN mr-2">
                                    <span class="_textN">{{ $diff }}ans</span>
                                </h6><br>

                            </div>
                            <h6 class="_txtN">
                                <span class="_textN">Etat
                                    civil: </span>{{ json_decode($membre->info)->civil_state }}
                            </h6>
                            <h6 class="_txtN"><span class="_textN">Nationalité:</span>
                                {{ json_decode($membre->info)->nationalite }}</h6>
                            <h6 class="_txtN"><span class="_textN">Metier:</span>
                                {{ json_decode($membre->info)->metier }}</h6>
                            <h6 class="_txtN"><span class="_textN">Competence:</span>
                                {{ json_decode($membre->info)->metier }}</h6>
                            <h6 class="_txtN"><span class="_textN">Activite/passion:</span>
                                {{ json_decode($membre->info)->talents }}</h6>

                            <div class="d-flex justify-content-between mt-3">
                                <div class="emailContent text-center" style="font-size: 1.5rem">
                                    {{-- <span class="mdi mdi-credit-card"></span> --}}
                                    <p style="font-size: 12px" class="m-0 text-primary">
                                        {{ json_decode($membre->info)->numerologie }}</p>
                                    <p style="font-size: 12px" class="m-0">Numerologie</p>

                                </div>
                                <div class="phoneContent text-center" style="font-size: 1.5rem">
                                    {{-- <span class="mdi mdi-star"></span> --}}
                                    <p style="font-size: 12px" class="m-0 text-primary">
                                        {{ json_decode($membre->info)->signe_astro }}</p>
                                    <p style="font-size: 12px" class="m-0">Signe astrologique</p>

                                </div>
                                <div class="phoneContent text-center" style="font-size: 1.5rem">
                                    {{-- <span class="mdi mdi-drupal"></span> --}}
                                    <p style="font-size: 12px" class="m-0 text-primary">
                                        {{ json_decode($membre->info)->animal_totem }}</p>
                                    <p style="font-size: 12px" class="m-0">Animal totem</p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="profile1 p-2 text-center rounded">
                            <div class="emailContent" style="font-size: 1.5rem">
                                <span class="mdi mdi-email"></span>
                                <p style="font-size: 12px">{{ json_decode($membre->info)->email }}</p>
                            </div>
                            <div class="phoneContent" style="font-size: 1.5rem">
                                <span class="mdi mdi-cellphone"></span>
                                <p style="font-size: 12px">{{ json_decode($membre->info)->telephone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="profile1 p-2 rounded">
                            <div class="imgB">
                                <img src="{{ json_decode($membre->info)->photo_buddy }}" alt="" class="imgBuddy">
                                <div class="pt-2">
                                    <h6 class="text-capitalize">{{ json_decode($membre->info)->buddy }}
                                    </h6>
                                </div>
                            </div>

                            <div class="imgB pt-4">
                                <img src="{{ json_decode($membre->info)->frere_t_photo }}" alt="" class="imgBuddy">
                                <div class="pt-2">
                                    <h6 class="text-capitalize">{{ json_decode($membre->info)->buddy }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="niveau">
                {{-- Niveau 1 --}}
                @foreach ($membre->evenement_membres as $evenement_membre)
                    @if ($evenement_membre->evenement->type === 'N1')
                        <div class="py-4 w-100">
                            <p class="text-primary m-0" style="font-size: 1rem; font-weight: 600">Niveau 1</p>
                            <div class="borderP p-3">
                                <div class="row w-100 justify-content-between">
                                    <div class="col-12 col-md-8">
                                        <span class="_textN"
                                            style="font-weight: 600">{{ $evenement_membre->evenement->pays }} -
                                            {{ $evenement_membre->evenement->ville }} -
                                            {{ $evenement_membre->evenement->centre }} -
                                            {{ $participants->count() }}
                                            participants</span><br>
                                        <span class="_textN" style="font-weight: 600">Du
                                            {{ date('d', strtotime($evenement_membre->evenement->date_debut)) }} au
                                            {{ date('d F Y', strtotime($evenement_membre->evenement->date_fin)) }}</span>
                                    </div>
                                    <div class="col-12 col-md-4 d-flex">
                                        @foreach ($membre->petit_groupe_membres as $mpg)
                                            <div class="text-center">
                                                <img src="{{ $mpg->petit_groupe->grand_groupe->photo }}" alt=""
                                                    class="imgBuddy" style="width: 250px">
                                                <div class="pt-2">
                                                    <h6 class="text-capitalize">Grand groupe</h6>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <img src="{{ $mpg->petit_groupe->photo }}" alt="" class="imgBuddy"
                                                    style="width: 250px">
                                                <div class="pt-2">
                                                    <h6 class="text-capitalize">Petit groupe</h6>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($evenement_membre->evenement->type === 'N2')
                        <div class="py-4 w-100">
                            <p class="text-success m-0" style="font-size: 1rem; font-weight: 600">Niveau 2</p>
                            <div class="borderP p-3">
                                <div class="row w-100 justify-content-between">
                                    <div class="col-12 col-md-8">
                                        <span class="_textN" style="font-weight: 600"><span class="_textN"
                                                style="font-weight: 600">{{ $evenement_membre->evenement->pays }} -
                                                {{ $evenement_membre->evenement->ville }} -
                                                {{ $evenement_membre->evenement->centre }}</span> -
                                            {{ $participants->count() }}
                                            participants</span><br>
                                        <span class="_textN" style="font-weight: 600">Du
                                            {{ date('d', strtotime($evenement_membre->evenement->date_debut)) }} au
                                            {{ date('d F Y', strtotime($evenement_membre->evenement->date_fin)) }}</span><br>
                                        <h6 class="_txtN pt-2"><span class="_textN">Buddy:</span>
                                            {{ json_decode($membre->info)->buddy }}</h6>
                                        <h6 class="_txtN"><span class="_textN">Saut quantique:</span>
                                            {{ json_decode($membre->info)->sautQDN2 }}</h6>
                                        <h6 class="_txtN"><span class="_textN">Contrat:</span>
                                            {{ json_decode($membre->info)->contrat }}</h6>
                                    </div>
                                    <div class="col-12 col-md-4 d-flex">
                                        @foreach ($membre->petit_groupe_membres as $mpg)
                                            <div class="text-center">
                                                <img src="{{ $mpg->petit_groupe->grand_groupe->photo }}" alt=""
                                                    class="imgBuddy" style="width: 250px">
                                                <div class="pt-2">
                                                    <h6 class="text-capitalize">Grand groupe</h6>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <img src="{{ $mpg->petit_groupe->photo }}" alt="" class="imgBuddy"
                                                    style="width: 250px">
                                                <div class="pt-2">
                                                    <h6 class="text-capitalize">Petit groupe</h6>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($evenement_membre->evenement->type === 'N3')
                        <div class="py-4 w-100">
                            <p class="text-danger p-0 m-0 " style="font-size: 1rem; font-weight: 600">Niveau 3</p>
                            <div class="borderP p-3">
                                <div class="row w-100 justify-content-between">
                                    <div class="col-12 col-md-8">
                                        <span class="_textN"
                                            style="font-weight: 600">{{ $evenement_membre->evenement->pays }} -
                                            {{ $evenement_membre->evenement->ville }} -
                                            {{ $evenement_membre->evenement->centre }}</span><br>
                                        <div class="pt-2">
                                            <h6 class="_txtN "><span class="_textN">Week-end
                                                    {{ $evenement_membre->evenement->numero_week_end }}: du
                                                    {{ date('d', strtotime($evenement_membre->evenement->date_debut)) }}
                                                    au
                                                    {{ date('d F Y', strtotime($evenement_membre->evenement->date_fin)) }}
                                                    -
                                                    {{ $participants->count() }}
                                                    participants - {{ $evenement_membre->evenement->adresse }} -
                                                    {{ $evenement_membre->evenement->lieu }}</span></h6>
                                        </div>
                                        <div class="pt-2">
                                            <h6 class="_txtN"><span class="_textN">Leader
                                                    inspirant:</span>
                                                {{ json_decode($membre->info)->leader_inspirant }}
                                            </h6>
                                            <h6 class="_txtN"><span class="_textN">Frere de
                                                    tribut:</span>
                                                {{ json_decode($membre->info)->tribut_frere }}</h6>
                                            <h6 class="_txtN"><span class="_textN">Saut quantique:</span>
                                                {{ json_decode($membre->info)->sautQProjetN3 }}</h6>
                                            <h6 class="_txtN"><span class="_textN">Pourcentage
                                                    chaise:</span>
                                                {{ json_decode($membre->info)->chaise_pourcentage }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="text-center w-100">
                                            <img src="{{ json_decode($membre->info)->frere_t_photo }}" alt=""
                                                class="imgBuddy" style="width: 250px">
                                            <div class="pt-2">
                                                <h6 class="text-capitalize">Tribut</h6>
                                            </div>
                                        </div>
                                        <div class="text-center w-100">
                                            <img src="{{ json_decode($membre->info)->frere_t_photo }}" alt=""
                                                class="imgBuddy" style="width: 250px">
                                            <div class="pt-2">
                                                <h6 class="text-capitalize">Frere de tribut</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="pt-4">
                    <div id="accordion1" class="w-100">
                        <div class="borderP w-100">
                            <div class="card-headers w-100" id="headingThree1">
                                <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block"
                                    data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false"
                                    aria-controls="collapseThree1">
                                    Lien avec les autre membres de la communaute
                                </div>
                            </div>
                            {{-- {{ dd($links) }} --}}
                            <div id="collapseThree1" class="collapse show" aria-labelledby="headingThree1"
                                data-parent="#accordion1">
                                <div class="px-4 py-4">
                                    <div class="py-2">
                                        <a href="{{ route('admin.create_links', $membre->id) }}"
                                            class="btn btn-add">Créer un lien avec
                                            <b>{{ json_decode($membre->info)->nom }}</b></a>
                                    </div>
                                    <div class="borderP table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Membre</th>
                                                    <th scope="col">Lien</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($lien))
                                                    @foreach ($lien as $link)
                                                        <tr>
                                                            <td><a
                                                                    href="{{ route('show_profile', $link->prospect->id) }}">
                                                                    {{ json_decode($link->prospect->info)->prenom }}
                                                                    {{ json_decode($link->prospect->info)->nom }}</a>
                                                            </td>
                                                            <td>{{ $link->type_lien->name }}</td>
                                                        </tr>
                                                    @endforeach

                                                @endif
                                                @if (isset($links))
                                                    @foreach ($links as $link)
                                                        <tr>
                                                            <td><a href="{{ route('show_profile', $link->membre->id) }}">
                                                                    {{ json_decode($link->membre->info)->prenom }}
                                                                    {{ json_decode($link->membre->info)->nom }}</a>
                                                            </td>
                                                            <td>{{ $link->type_lien->name }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>

                                        </table>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>

                <div class="py-4 w-100">
                    <p class="text-danger p-0 m-0 " style="font-size: 1rem; font-weight: 600">Staffing</p>
                    <div class="borderP p-3">
                        <div class="borderP table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Individu</th>
                                        <th scope="col">Type rôle</th>
                                        <th scope="col">Rôle</th>
                                        <th scope="col">Taux de passage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>02/03/2021</td>
                                        <td>Za</td>
                                        <td>Cheff</td>
                                        <td>Cheff b</td>
                                        <td>15%</td>
                                    </tr>
                                    <tr>
                                        <td>02/03/2021</td>
                                        <td>Izy</td>
                                        <td>Staff</td>
                                        <td>Staff b</td>
                                        <td>85%</td>
                                    </tr>
                                </tbody>

                            </table>

                        </div>
                        <div class="mt-4 float-right">
                            <p class="m-0" style="color: rgb(10, 36, 53); font-weight: 600">Moyen taux de
                                passage
                                N1-> N2 : 75%
                            </p>
                            <p class="m-0" style="color: rgb(10, 36, 53); font-weight: 600">Moyen taux de
                                passage
                                N2-> N3 : 25%</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
