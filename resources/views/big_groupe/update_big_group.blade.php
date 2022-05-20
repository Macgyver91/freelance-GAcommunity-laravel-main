@extends('layouts.app')

@section('content')
<div class="row row justify-content-center">
    <div class="col-lg-12">
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modification de grand groupe
                </h4>
            </div>
            <div class="card-body">
                <div class="create-event-form">
                    <form action="{{ route('admin.update_g_group', $g_group) }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="borderP p-3 mb-3">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <label class="" for="type">Type</label>
                                    <select id="type" name="type" class="form-control @error('type') border-warning
                                    @enderror">
                                        <option value="{{ $g_group->type }}">{{ $g_group->type }}</option>
                                        <option value="N1">N1</option>
                                        <option value="N2">N2</option>
                                        <option value="N3">N3</option>
                                    </select>
                                    @error('type')
                                    <div class="text-warning">
                                        Le champs type est obligatoire
                                    </div>
                                    @enderror
                                </div>


                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="nom">Nom</label>
                                        <input type="text" value="{{ $g_group->nom }}" name="nom"
                                            class="form-control @error('nom') border-warning @enderror" id="nom"
                                            placeholder="Nom du grand-groupe">
                                    </div>
                                    @error('nom')
                                    <div class="text-warning">
                                        Le champs nom est obligatoire
                                    </div>
                                    @enderror

                                </div>



                            </div>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="mantra">Mantra</label>
                                        <input type="text" value="{{ $g_group->mantra }}" name="mantra"
                                            class="form-control @error('mantra') border-warning @enderror w-100"
                                            id="mantra" placeholder="Mantra">
                                    </div>
                                    @error('mantra')
                                    <div class="text-warning">
                                        Le champs mantra est obligatoire
                                    </div>
                                    @enderror

                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="declaration">Declaration</label>
                                        <input type="text" value="{{ $g_group->declaration }}" name="declaration"
                                            class="form-control @error('declaration') border-warning @enderror w-100"
                                            id="declaration" placeholder="Declaration">
                                    </div>
                                    @error('declaration')
                                    <div class="text-warning">
                                        Le champs mantra est obligatoire
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="borderP p-3 mb-3">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div class="imgFF mb-2">
                                        <img id="preview-image-before-upload" src="{{ $g_group->photo }}"
                                            alt="preview image" style="max-height: 100px;">
                                    </div>
                                    <div>
                                        <label class="" for="photo">Photo</label>
                                        <input type="file" name="photo"
                                            class="form-control @error('photo') border-warning @enderror w-100"
                                            id="photo" {{-- onchange="getUploaded()" --}}>
                                    </div>
                                    @error('photo')
                                    <div class="text-warning">
                                        Le champs photo est obligatoire
                                    </div>
                                    @enderror

                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div class="imgFF mb-2">
                                        <img id="preview-image-before-upload1" src="{{ $g_group->logo }}"
                                            alt="preview image" style="height: 100px; width:auto">
                                    </div>
                                    <div>
                                        <label class="" for="logo">Logo</label>
                                        <input type="file" name="logo"
                                            class="form-control @error('logo') border-warning @enderror w-100" id="logo"
                                            {{-- onchange="getUploaded1()" --}}>
                                    </div>
                                    @error('logo')
                                    <div class="text-warning">
                                        Le champs logo est obligatoire
                                    </div>
                                    @enderror

                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div class="mb-3 mb-3">
                                        <audio class="mt-2" id="prev-audio" controls
                                            src="{{ $g_group->musique_choree }}">
                                            Votre navigateur ne support pas
                                            <code>ce type de fichier.</code>
                                        </audio>
                                    </div>
                                    <div>
                                        <label class="" for="musique_choree">Music choree</label>
                                        <input type="file" name="musique_choree"
                                            class="form-control @error('musique_choree') border-warning @enderror w-100"
                                            id="musique_choree" {{-- onchange="getUploaded2()" --}}>
                                    </div>
                                    @error('musique_choree')
                                    <div class="text-warning">
                                        Le champs Music chorée est obligatoire
                                    </div>
                                    @enderror

                                </div>
                            </div>


                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <div class="imgFF">
                                        <video controls class="mb-2" id="prev-video" width="200">
                                            <source src="{{ $g_group->video_choree }}" type="video/avi">
                                            <source src="{{ $g_group->video_choree }}" type="video/gif">
                                            <source src="{{ $g_group->video_choree }}" type="video/mp4">
                                            <track label="English" kind="captions" srclang="en" src="" default>

                                            Désolé, votre navigateur ne prend pas en charge les vidéos intégrées.
                                        </video>
                                    </div>

                                    <div>
                                        <label class="" for="video_choree">Video choree</label>
                                        <input type="file" name="video_choree"
                                            class="form-control @error('video_choree') border-warning @enderror w-100"
                                            id="video_choree" {{-- onchange="getUploaded3()" --}}>
                                    </div>
                                    @error('video_choree')
                                    <div class="text-warning">
                                        Le champs video chorée est obligatoire
                                    </div>
                                    @enderror

                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <div class="imgFF mb-2">
                                        <img id="preview-image-before-upload2" src="{{ $g_group->photo_drapeau }}"
                                            alt="preview image" style="max-height: 100px;">
                                    </div>
                                    <div>
                                        <label class="" for="photo_drapeau">Photo drapeau</label>
                                        <input type="file" name="photo_drapeau"
                                            class="form-control @error('photo_drapeau') border-warning @enderror w-100"
                                            id="photo_drapeau" {{-- onchange="getUploaded4()" --}}>
                                    </div>
                                    @error('photo_drapeau')
                                    <div class="text-warning">
                                        Le champs photo drapeau est obligatoire
                                    </div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="borderP p-3 mb-3">
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="capitaine">Capitaine</label>
                                        <select name="capitaine" id="capitaine"
                                            class="form-control @error('capitaine') border-warning @enderror">
                                            @foreach ($allMembres as $membre)
                                            <option {{ $g_group->capitaine === $membre->id ? 'selected' : '' }}
                                                value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('capitaine')
                                    <div class="text-warning">
                                        Le champs capitaine est obligatoire
                                    </div>
                                    @enderror

                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="co_capitaine">Co-capitaine</label>

                                        <select name="co_capitaine" id="co_capitaine"
                                            class="form-control @error('co_capitaine') border-warning @enderror">
                                            @foreach ($allMembres as $membre)
                                            <option {{ $g_group->co_capitaine === $membre->id ? 'selected' : '' }}
                                                value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('co_capitaine')
                                    <div class="text-warning">
                                        Le champs co-capitaine est obligatoire
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="resp_com">Responsable com</label>

                                        <select name="resp_com" id="resp_com"
                                            class="form-control @error('resp_com') border-warning @enderror">
                                            @foreach ($allMembres as $membre)
                                            <option {{ $g_group->resp_com === $membre->id ? 'selected' : '' }}
                                                value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('resp_com')
                                    <div class="text-warning">
                                        Le champs resp_com est obligatoire
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="resp_heritage">Responsable heritage</label>
                                        <select name="resp_heritage" id="resp_heritage"
                                            class="form-control @error('resp_heritage') border-warning @enderror">
                                            @foreach ($allMembres as $membre)
                                            <option {{ $g_group->resp_heritage === $membre->id ? 'selected' : '' }}
                                                value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('resp_heritage')
                                    <div class="text-warning">
                                        Le champs responsable heritage est obligatoire
                                    </div>
                                    @enderror

                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="resp_anges">Responsable anges</label>

                                        <select name="resp_anges" id="resp_anges"
                                            class="form-control @error('resp_anges') border-warning @enderror">
                                            @foreach ($allMembres as $membre)
                                            <option {{ $g_group->resp_anges === $membre->id ? 'selected' : '' }}
                                                value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('resp_anges')
                                    <div class="text-warning">
                                        Le champs responsable anges est obligatoire
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="resp_bateau">Responsable bateau</label>
                                        {{-- <input type="number" value="{{ $g_group->resp_bateau }}" name="resp_bateau"
                                            class="form-control @error('resp_bateau') border-warning @enderror w-100"
                                            id="resp_bateau" placeholder="Responsable bateau"> --}}
                                        <select name="resp_bateau" id="resp_bateau"
                                            class="form-control @error('resp_bateau') border-warning @enderror">
                                            {{-- <option value="{{ $g_group->resp_bateau }}">Selectionner un reponsable
                                                bateau
                                            </option> --}}
                                            @foreach ($allMembres as $membre)
                                            <option {{ $g_group->resp_bateau === $membre->id ? 'selected' : '' }}
                                                value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('resp_bateau')
                                    <div class="text-warning">
                                        Le champs responsable bateau est obligatoire
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
{{-- <script>
    function getUploaded() {
        var inputFile = document.querySelector('#photo');
        document.getElementById('preview-image-before-upload').src = URL.createObjectURL(inputFile.files[0]);
    }

    function getUploaded1() {
        var inputFile = document.querySelector('#logo');
        document.getElementById('preview-image-before-upload1').src = URL.createObjectURL(inputFile.files[0]);
    }

    function getUploaded2() {
        var inputFile = document.querySelector('#musique_choree');
        document.getElementById('prev-audio').src = URL.createObjectURL(inputFile.files[0]);
    }

    function getUploaded3() {
        var inputFile = document.querySelector('#video_choree');
        document.getElementById('prev-video').src = URL.createObjectURL(inputFile.files[0]);
    }

    function getUploaded4() {
        var inputFile = document.querySelector('#photo_drapeau');
        document.getElementById('preview-image-before-upload2').src = URL.createObjectURL(inputFile.files[0]);
    }
</script> --}}