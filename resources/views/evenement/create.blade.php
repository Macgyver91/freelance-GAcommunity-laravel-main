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
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Creation Evenement</h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.store_event') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="type">Type</label>
                                        <select id="type" name="type" class="form-control" @error('type') border-warning
                                            @enderror value="type">
                                            <option value="N1">N1</option>
                                            <option value="N2">N2</option>
                                            <option value="N3">N3</option>
                                            <option value="N3">N4</option>
                                        </select>
                                    </div>
                                    @error('type')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="numero_week_end">Numero Week-end</label>
                                        <input value="{{ old('numero_week_end') }}" type="number" name="numero_week_end"
                                            class="form-control @error('numero_week_end') border-warning @enderror"
                                            id="numero_week_end" placeholder="Numero week-end">
                                    </div>
                                    @error('numero_week_end')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="pays">Pays</label>
                                        <select id="pays" name="pays" class="form-control" @error('pays') border-warning
                                            @enderror value="pays">
                                            <option value="France">France</option>
                                            {{-- <option value="Angleterre">Angleterre</option>
                                        <option value="Afrique du sud">Afrique du sud</option>
                                        <option value="Egypte">Egypte</option>
                                        <option value="Etats Unis">Etats Unis</option>
                                        <option value="Japon">Japon</option> --}}
                                        </select>
                                    </div>

                                    @error('pays')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="ville">Ville</label>
                                        <input value="{{ old('ville') }}" type="text" name="ville"
                                            class="form-control @error('ville') border-warning @enderror" id="ville"
                                            placeholder="Ville">
                                    </div>
                                    @error('ville')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="date_debut">Date de debut</label>
                                        <input type="date" name="date_debut"
                                            class="form-control @error('date_debut') border-warning @enderror w-100"
                                            id="date_debut" placeholder="Date de debut">
                                    </div>
                                    @error('date_debut')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="date_fin">Date de fin</label>
                                        <input type="date" name="date_fin"
                                            class="form-control @error('date_fin') border-warning @enderror w-100"
                                            id="date_fin" placeholder="Date de fin">
                                    </div>
                                    @error('date_fin')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="centre">Centre</label>
                                        <input value="{{ old('centre') }}" type="text" name="centre"
                                            class="form-control @error('centre') border-warning @enderror" id="centre"
                                            placeholder="Centre">
                                    </div>
                                    @error('centre')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="lieu">Lieu</label>
                                        <input value="{{ old('lieu') }}" type="text" name="lieu"
                                            class="form-control @error('lieu') border-warning @enderror" id="lieu"
                                            placeholder="Lieu">
                                    </div>
                                    @error('lieu')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="adresse">Adresse</label>
                                        <input value="{{ old('adresse') }}" type="text" name="adresse"
                                            class="form-control @error('adresse') border-warning @enderror" id="adresse"
                                            placeholder="Adresse">
                                    </div>
                                    @error('adresse')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-row">
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="coach">Coach</label>
                                        <input value="{{ old('coach') }}" type="text" name="coach"
                                            class="form-control @error('coach') border-warning @enderror" id="coach"
                                            placeholder="Coach">
                                    </div>
                                    @error('coach')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <div>
                                        <label class="" for="tarif">Tarif (en Euro)</label>
                                        <input value="{{ old('tarif') }}" type="number" step="0.01" name="tarif"
                                            class="form-control @error('tarif') border-warning @enderror" id="tarif"
                                            placeholder="Tarif">
                                    </div>
                                    @error('tarif')
                                        <div class="text-warning">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
