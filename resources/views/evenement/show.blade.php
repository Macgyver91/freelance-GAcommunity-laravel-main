@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card pt-2">
                <div class="card-header">
                    <h3 class="text-center text-success"> Detail de l'evenement</h3>
                </div>
                <div class="card-content p-4 print-container" id="_div">
                    <div class="title_txt">Information de l'evenement n*<span
                            class="text-primary">{{ $event->id }}</span>
                    </div>
                    <div class="w-100 pt-4">
                        @if (!isset($grand_groupe))
                            @can('event_management')
                                <div class="title_txt">Ajouter grand groupe a cet evenement</div>

                                <form action="{{ route('admin.add_grand_groupe', $event) }}" method="post"
                                    class="">
                                    @csrf

                                    <input type="hidden" name="evenement_id" value="{{ $event->id }}">

                                    <div class="form-group col-12 p-0">

                                        <div>
                                            <p class="mb-1">Ajouter grand groupe</p>
                                            <select class="form-control" name="grand_groupe_id"
                                                onchange="if(this.selectedIndex === 1) window.location.href='/admins/add_membre';">
                                                <option value="" class="py-2">
                                                    Selectionnez un grand groupe
                                                </option>
                                                <option value="" class="py-2">
                                                    Creer un grand groupe
                                                </option>
                                                @if (isset($grand_groupes))
                                                    @foreach ($grand_groupes as $gg)
                                                        <option value="{{ $gg->id }}">{{ $gg->nom }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        @error('grand_groupe_id')
                                            <div class="text-warning">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Ajouter grand
                                        groupe</button>
                                </form>
                            @endcan

                        @endif
                    </div>
                    <div class="row borderP">
                        <div class="col-md-8">

                            <div class="profile  p-2 rounded">
                                <h6 class="_txtN"><span class="_textN">{{ $event->pays }} -
                                        {{ $event->ville }}</span>
                                </h6>

                                <h6 class="_txtN"><span class="_textN">Du
                                        {{ date('d', strtotime($debut)) }}
                                        au
                                        {{ date('d F Y', strtotime($fin)) }}
                                    </span>
                                </h6>
                                <h6 class="_txtN text-capitalize"><span class="_textN">{{ $event->lieu }}</span>
                                </h6>
                                <h6 class="_txtN text-capitalize"><span class="_textN">
                                        {{ $event->centre }}</span>
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-4">

                            @if (isset($grand_groupe))
                                <div class="profile1 p-2 rounded">
                                    <div class="imgB">
                                        <img src="{{ $grand_groupe->photo }}" alt="" class="imgBuddy">
                                        <div class="pt-2">
                                            <h6 class="text-uppercase _txtN">
                                                {{ $grand_groupe->nom }}</h6>
                                        </div>
                                    </div>

                                </div>

                            @else
                                <p>Aucun de grand groupe dans cet evenement</p>
                            @endif
                        </div>

                    </div>



                    <div class="row borderP mt-3">
                        <div class="col-md-8">

                            <div class="profile  p-2 rounded">
                                <h6 class="_txtN"><span class="_textN">
                                        Nom de l'evenement <span class="text-primary"></span></span>
                                </h6>
                                <h6 class="_txtN"><span
                                        class="text-primary">{{ $participants->count() }}</span>
                                    participants inscrit
                                </h6>
                                <div class="py-2">
                                    <h6 class="_txtN">"Nous changeons le mondes en or"</h6>
                                </div>
                                <div class="pt-3">
                                    <h6 class="_txtN text-capitalize"><span class="_textN">Taux de passage au
                                            niveau
                                            suivant:</span>
                                        70%</h6>
                                </div>
                                <div class="py-2">
                                    <h6 class="_txtN text-capitalize"><span class="_textN">Taux de
                                            satisfaction:</span>
                                        80%</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="profile1 p-2 rounded">

                                @if (isset($grand_groupe))
                                    <div class="imgB">
                                        <img src="{{ isset($grand_groupe) ? $grand_groupe->photo : '' }}" alt=""
                                            class="imgBuddy">
                                        <div class="pt-2">
                                            <h6 class="text-uppercase _txtN">
                                                {{ isset($grand_groupe) ? $grand_groupe->nom : '' }}
                                            </h6>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.remove_grand_groupe', $event) }}" method="post"
                                        class="">
                                        @csrf
                                        @method("DELETE")
                                        <button class="btn btn-add" type="submit">
                                            Retirer grand groupe
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                    </div>

                    {{-- Accordion 1 --}}
                    <div class="row pt-3">
                        <x-minigroupe-list :grandgroupe="$grand_groupe" :staffParticipe="$staffParticipe" />
                    </div>
                    {{-- Fin accordion 1 --}}
                    {{-- Accordion 2 --}}
                    <div class="row pt-3">
                        <x-participant-list :arrayMembre="$arrayMembre" :nbrMembre="$nbrMembre"
                            :participants="$participants" :membres="$membres" :event="$event" />
                    </div>
                    {{-- Fin Accordion 2 --}}
                    {{-- Debut accordion 3 --}}
                    <div class="row pt-3">
                        <x-lien-list :membres="$membres" :arrayMembre="$arrayMembre" :participants="$participants" />
                    </div>

                    {{-- Fin accordion 3 --}}
                    {{-- Debut accordion 4 --}}

                    <div class="row pt-3">
                        <x-staff-list :staffmembres="$staffmembres" :staffParticipe="$staffParticipe"
                            :staffParticipe="$staffParticipe" :staffs="$staffs" :event="$event" :membres="$membres" />
                    </div>

                    {{-- Fin accordion 4 --}}
                    {{-- Accordion 5 --}}
                    <div class="row pt-3">
                        <x-abandon-list :participants="$participants" :abandons="$abandons" />
                    </div>
                    {{-- Fin accordion 5 --}}

                </div>
                <script>
                    function handleClick(id) {
                        document.getElementById("membre_id_input").value = id;
                    }
                    // window.location.href = url
                </script>
            @endsection
