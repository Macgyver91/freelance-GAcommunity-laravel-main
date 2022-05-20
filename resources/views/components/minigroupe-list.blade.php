@props(['grandgroupe' => $grandgroupe, 'staffParticipe' => $staffParticipe])
<div id="accordion" class="w-100">
    <div class="borderP w-100">
        <div class="card-headers w-100" id="headingThree">
            <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block" data-toggle="collapse"
                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Les mini-groupes
            </div>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
                <div class="row">
                    @if (isset($grandgroupe->petit_groupes))
                        @foreach ($grandgroupe->petit_groupes as $pg)
                            <div class="col-12 col-md-3">
                                <div class="mb-3">

                                    <div class="imgGg">
                                        <p class="_textNMM">Groupe {{ $pg->id }}</p>
                                        <img class="imgPG0" src="{{ $pg->photo }}" alt="">
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="borderP p-2">
                                        <p class="_textNMM">
                                            Staff:
                                        <ul class="list-item">
                                            @if (isset($staffParticipe))
                                                @foreach ($staffParticipe->staff_membres as $sp)
                                                    <li>{{ json_decode($sp->membre->info)->prenom }}
                                                        {{ json_decode($sp->membre->info)->nom }}
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="w-100 text-center">
                            <h3>Pas de mini-groupe</h3>
                        </div>
                    @endif
                </div>
            </div>
            {{-- START ADD PETIT GROUPE --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Création de petit groupe
                    </h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.store_petit_groupe') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="capitaine">Capitaine</label>
                                        <input value="{{ old('capitaine') }}" type="number" name="capitaine"
                                            class="form-control @error('capitaine') border-warning @enderror"
                                            id="capitaine" placeholder="capitaine">
                                    </div>
                                    @error('capitaine')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <input type="hidden" name="grand_groupe_id"
                                value="{{ isset($grandgroupe) ? $grandgroupe->id : '' }}">

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="" for="photo">Photo</label>
                                    <input type="file" name="photo"
                                        class="form-control @error('photo') border-warning @enderror w-100" id="photo"
                                        onchange="getUploaded()">
                                </div>
                                @error('photo')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload"
                                    src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                                    alt="preview image" style="max-height: 250px;">
                            </div> --}}

                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- END ADD PETIT GROUPE --}}
        </div>
    </div>
</div>
