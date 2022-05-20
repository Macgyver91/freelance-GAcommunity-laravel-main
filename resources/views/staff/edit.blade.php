@extends('layouts.app')

@section('content')
    <div class="row row justify-content-center">
        <div class="col-lg-6">

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
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modification de groupe de
                        staff</h4>
                </div>

                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.update_staff', $staff) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')



                            <div class="form-group col-12">
                                <div>
                                    <label class="" for="nom">Nom</label>
                                    <input value="{{ $staff->nom }}" type="text" name="nom"
                                        class="form-control @error('nom') border-warning @enderror" id="nom"
                                        placeholder="le nom du staff">
                                </div>
                                @error('nom')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="" for="mantra">Mantra</label>
                                    <input value="{{ $staff->mantra }}" type="text" name="mantra"
                                        class="form-control @error('mantra') border-warning @enderror" id="mantra"
                                        placeholder="le mantra du staff">
                                </div>
                                @error('mantra')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="" for="type">Type</label>
                                    <input value="{{ $staff->type }}" type="text" name="type"
                                        class="form-control @error('type') border-warning @enderror" id="type"
                                        placeholder="le type de staff">
                                </div>
                                @error('type')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="" for="logo">Logo</label>
                                    <input type="file" name="logo"
                                        class="form-control @error('logo') border-warning @enderror w-100" id="logo"
                                        onchange="getUploadedLogo()">
                                </div>
                                @error('logo')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-2">
                                <img class="w-100" id="preview-logo-before-upload" src="{{ $staff->logo }}"
                                    alt="preview image" style="max-height: 250px; width: auto">
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="" for="photo">Photo</label>
                                    <input type="file" name="photo"
                                        class="form-control @error('photo') border-warning @enderror w-100" id="photo"
                                        onchange="getUploadedPhoto()">
                                </div>
                                @error('photo')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-2">
                                <img class="pb-4" id="preview-photo-before-upload" src="{{ $staff->photo }}"
                                    alt="preview image" style="max-height: 250px; width:100%">
                            </div>

                            {{-- <div class="form-group col-12">
                                <div>
                                    <label class="sr-only" for="event_mem_id">event_mem_id</label>
                                    <input value="{{ $staff->event_mem_id }}" type="number" name="event_mem_id"
                                        class="form-control @error('event_mem_id') border-warning @enderror"
                                        id="event_mem_id" placeholder="event_mem_id">
                                </div>
                                @error('event_mem_id')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="sr-only" for="event_gg_id">event_gg_id</label>
                                    <input value="{{ $staff->event_gg_id }}" type="number" name="event_gg_id"
                                        class="form-control @error('event_gg_id') border-warning @enderror" id="event_gg_id"
                                        placeholder="event_gg_id">
                                </div>
                                @error('event_gg_id')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="sr-only" for="event_abandon_id">event_abandon_id</label>
                                    <input value="{{ $staff->event_abandon_id }}" type="number" name="event_abandon_id"
                                        class="form-control @error('event_abandon_id') border-warning @enderror"
                                        id="event_abandon_id" placeholder="event_abandon_id">
                                </div>
                                @error('event_abandon_id')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <div>
                                    <label class="sr-only" for="ev_abd_membre_id">ev_abd_membre_id</label>
                                    <input value="{{ $staff->ev_abd_membre_id }}" type="number" name="ev_abd_membre_id"
                                        class="form-control @error('ev_abd_membre_id') border-warning @enderror"
                                        id="ev_abd_membre_id" placeholder="ev_abd_membre_id">
                                </div>
                                @error('ev_abd_membre_id')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}

                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        function getUploadedLogo() {
            var inputFile = document.querySelector('#logo');
            document.getElementById('preview-logo-before-upload').src = URL.createObjectURL(inputFile.files[0]);
        }

        function getUploadedPhoto() {
            var inputFile = document.querySelector('#photo');
            document.getElementById('preview-photo-before-upload').src = URL.createObjectURL(inputFile.files[0]);
        }
    </script>
@endsection
