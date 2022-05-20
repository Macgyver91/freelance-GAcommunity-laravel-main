@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card pt-2">
                <div class="card-header">
                    <h3 class="text-center text-success"> Détail du <span
                            class="text-danger">{{ $big_groupe->nom }}</span>
                    </h3>
                    <button class="btn btnAdd" onclick="printPdf()">Export
                        PDF</button>
                </div>
                <div class="card-content p-4 print-container" id="_div">
                    <div class="title_txt">Information de grand groupe <span
                            class="text-primary">{{ $big_groupe->nom }}</span></div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="profile borderP p-2 rounded">
                                <h6 class="text-uppercase _txtN"><span class="text-capitalize _textN">Identifiant:</span>
                                    {{ $big_groupe->id }}</h6>
                                <h6 class="text-uppercase _txtN"><span class="text-capitalize _textN">Type:</span>
                                    {{ $big_groupe->type }}</h6>
                                <h6 class="text-uppercase _txtN"><span class="text-capitalize _textN">Nom:</span>
                                    {{ $big_groupe->nom }}
                                </h6>
                                <h6 class="_txtN"><span class="_textN">Declaration:</span>
                                    {{ $big_groupe->declaration }}</h6>
                                <h6 class="_txtN"><span class="_textN">Mantra:</span>
                                    {{ $big_groupe->mantra }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile1 borderP p-2 rounded">

                                <h6 class="_txtN"><span class="_textN">Capitaine:</span>
                                    {{ $big_groupe->capitaine }}
                                </h6>
                                <h6 class="_txtN">
                                    <span class="_textN">Co-capitaine:</span>
                                    {{ $big_groupe->co_capitaine }}
                                </h6>
                                <h6 class="_txtN"><span class="_textN">Responsable com:</span>
                                    {{ $big_groupe->resp_com }}</h6>
                                <h6 class="_txtN"><span class="_textN">Responsable heritage:</span>
                                    {{ $big_groupe->resp_heritage }}</h6>
                                <h6 class="_txtN"><span class="_textN">Responsable anges:</span>
                                    {{ $big_groupe->resp_anges }}</h6>
                                <h6 class="_txtN text-capitalize"><span class="_textN">Responsable
                                        bateau:</span>
                                    {{ $big_groupe->resp_bateau }}</h6>
                            </div>
                        </div>
                    </div>
                    <div id="media">
                        <div class="py-4">
                            <div class="title_txt">Medias</div>
                        </div>
                        <div class="row">
                            <div class="media1 col-12 col-md-4">
                                <h4 class="titleMedia">Photo</h4>
                                <div class="imgF">
                                    <img class="shadow-sm rounded img-med" src="{{ $big_groupe->photo }}" alt="">
                                </div>
                            </div>
                            <div class="media2 col-12 col-md-4">
                                <h4 class="titleMedia">Logo</h4>
                                <div class="imgF">
                                    <img class="shadow-sm rounded img-med" src="{{ $big_groupe->logo }}" alt="">
                                </div>
                            </div>
                            <div class="media3 col-12 col-md-4">
                                <h4 class="titleMedia">Photo du drapeau</h4>
                                <div class="imgF">
                                    <img class="shadow-sm rounded img-med" src="{{ $big_groupe->photo_drapeau }}" alt="">
                                </div>
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="files col-12 col-md-4">
                                <h4 class="titleMedia">Musique choree</h4>
                                <audio class="mt-2" id="prev-audio" controls
                                    src="{{ $big_groupe->musique_choree }}">
                                    Votre navigateur ne support pas
                                    <code>ce type de fichier.</code>
                                </audio>
                            </div>
                            <div class="files1 col-12 col-md-4">
                                <h4 class="titleMedia">Video choree</h4>
                                <video controls class="rounded mb-2" id="prev-video" width="100%">
                                    <source src="{{ $big_groupe->video_choree }}" type="video/avi">
                                    <source src="{{ $big_groupe->video_choree }}" type="video/gif">
                                    <source src="{{ $big_groupe->video_choree }}" type="video/mp4">

                                    Désolé, votre navigateur ne prend pas en charge les vidéos intégrées.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
