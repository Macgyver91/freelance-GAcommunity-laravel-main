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
                <div class="card-header" style="text-align: center ">
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modification de prospect
                    </h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.update_prospect', $prospect) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="nom">Nom</label>
                                    <input value="{{ $prospect->nom }}" type="text" name="nom"
                                        class="form-control @error('nom') border-warning @enderror" id="nom"
                                        placeholder="Votre nom">
                                </div>
                                @error('nom')
                                    <div class="text-warning">
                                        Le champs nom est obligatoire
                                    </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="prenom">Prenom</label>
                                    <input type="text" value="{{ $prospect->prenom }}" name="prenom"
                                        class="form-control @error('prenom') border-warning @enderror" id="prenom"
                                        placeholder="Votre prenom">
                                </div>
                                @error('prenom')
                                    <div class="text-warning">
                                        Le champs prenom est obligatoire
                                    </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="email">Email</label>
                                    <input type="email" value="{{ $prospect->email }}" name="email"
                                        class="form-control @error('email') border-warning @enderror w-100" id="email"
                                        placeholder="Votre adresse email">
                                </div>
                                @error('email')
                                    <div class="text-warning">
                                        Le champs email est obligatoire
                                    </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="tel">Telephone</label>
                                    <input type="text" value="0{{ $prospect->tel }}" name="tel"
                                        class="form-control @error('tel') border-warning @enderror w-100" id="tel"
                                        placeholder="Votre numero de telephone">
                                </div>
                                @error('telephone')
                                    <div class="text-warning">
                                        Le champs telephone est obligatoire
                                    </div>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="type">Type</label>
                                    <select id="type" name="type" class="form-control" @error('type') border-warning
                                        @enderror>
                                        <option value="{{ $prospect->type }}">{{ $prospect->type }}</option>
                                        <option value="s">S</option>
                                        <option value="p">P</option>
                                        <option value="c">C</option>
                                    </select>
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
