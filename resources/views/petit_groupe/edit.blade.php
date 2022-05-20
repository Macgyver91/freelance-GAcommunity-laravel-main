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
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modification de petit groupe
                    </h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.update_petit_groupe', $petit_groupe) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <div>
                                        <label class="sr-only" for="capitaine">Capitaine</label>

                                        <select name="capitaine" id="capitaine"
                                            class="form-control @error('capitaine') border-warning @enderror">
                                            <option value="{{ $petit_groupe->capitaine }}">
                                                {{ $petit_groupe->capitaine }}
                                            </option>
                                            @foreach ($allMembres as $membre)
                                                <option value="{{ $membre->id }}">{{ json_decode($membre->info)->nom }}
                                                    {{ json_decode($membre->info)->prenom }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('capitaine')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="grand_groupe_id">Grand groupe</label>
                                    {{-- <input list="membre" name="membre_id" class="form-control" @error('membre_id')
                                    border-warning @enderror placeholder="Cherche membre"> --}}
                                    <select id="grand_groupe_id" name="grand_groupe_id" class="form-control"
                                        @error('grand_groupe_id') border-warning @enderror>
                                        {{-- <datalist id="membre"> --}}
                                        @foreach ($grand_groupes as $gg)
                                            <option {{ $petit_groupe->grand_groupe_id === $gg->id ? 'selected' : '' }}
                                                value="{{ $gg->id }}">{{ "$gg->nom" }}
                                            </option>
                                        @endforeach
                                        {{-- </datalist> --}}
                                    </select>
                                </div>
                                @error('grand_groupe_id')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="photo">Photo</label>
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

                            <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload" src="{{ $petit_groupe->photo }}"
                                    alt="preview image" style="max-height: 250px;">
                            </div>

                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        function getUploaded() {
            var inputFile = document.querySelector('#photo');
            document.getElementById('preview-image-before-upload').src = URL.createObjectURL(inputFile.files[0]);
        }
    </script>
@endsection
