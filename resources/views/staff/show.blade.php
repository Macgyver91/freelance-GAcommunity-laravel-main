@extends('layouts.app')

@section('content')


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
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title text-uppercase">{{ $staff->nom }}</h4>
            <div>
                @can('edit_staffs')
                    <form action="{{ route('admin.show_edit_staff', $staff->id) }}" method="get" class="">
                        @csrf
                        <button type="submit" class="btn btn-add">Modifier</button>
                    </form>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="pb-2">
                <h4 class="card-title "><span class="_textN">Evenement:</span> {{ $staff->evenement_id }}
                </h4>
                <h4 class="card-title"><span class="_textN">Mantra</span>: {{ $staff->mantra }}</h4>
            </div>


            <div class="row">
                <div class="col-12 col-md-6 mb-2">
                    <img id="preview-image-before-upload" class="borderP" src="{{ $staff->logo }}" alt="logo staff"
                        style="max-height: 250px; width: 100%">
                </div>

                <div class="col-12 col-md-6 mb-2">
                    <img id="preview-image-before-upload" class="borderP" src="{{ $staff->photo }}"
                        alt="photo staff" style="width: 100%">
                </div>
            </div>


        </div>

    </div>


    <div class="card">
        <div class="card-header">
            <h4 class="card-Title">Liste des membres</h4>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table aria-describedat="staffTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Membre</th>
                        </tr>
                    </thead>
                    @if ($staff_membres->count())
                        @foreach ($staff_membres as $staff_membre)
                            <tbody>
                                <tr>
                                    <td><a href="{{ route('show_profile', $staff_membre->membre->id) }}">
                                            {{ json_decode($staff_membre->membre->info)->nom }}
                                            {{ json_decode($staff_membre->membre->info)->prenom }}
                                        </a></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-add dropdown-toggle" type="button" id="dropdownMenu2"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            @can('membre_staff')
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                    style="background: #fff">
                                                    @can('edit_membres')
                                                        <a href="{{ route('admin.edit_membre', $staff_membre->membre->id) }}"
                                                            class="dropdown-item">
                                                            Modifier
                                                        </a>
                                                    @endcan
                                                    <form action="{{ route('admin.destroy_membre_staff', $staff_membre) }}"
                                                        method="post" class="">
                                                        @csrf
                                                        @method("DELETE")
                                                        <button class="dropdown-item" type="submit">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            @endcan
                                        </div>

                                    </td>
                                </tr>

                            </tbody>
                        @endforeach
                    @else
                        <tbody>
                            <tr>
                                <td colspan="5">Pas de data</td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
    </div>

    @can('membre_staff')
        <div class="card">
            <div class="card-header">
                <h4 class="card-Title">Ajouter des membres dans ce groupe de staff</h4>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.add_staff_membre', $staff) }}" method="post" class="">
                    @csrf

                    <div class="form-group col-12 p-0">
                        <div>
                            <p class="mb-1">Selectionner un membre</p>
                            <select class="form-control" name="membre_id">
                                @foreach ($membres as $membre)
                                    <option value="{{ $membre->id }}">{{ json_decode($membre->info)->nom }}
                                        {{ json_decode($membre->info)->prenom }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('membre_id')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <div>
                            <label class="" for="commentaire">Commentaire</label>
                            <input value="{{ old('commentaire') }}" type="text" name="commentaire"
                                class="form-control @error('commentaire') border-warning @enderror" id="commentaire"
                                placeholder="commentaire">
                        </div>
                        @error('commentaire')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <div>
                            <label class="" for="taux_de_passage">Taux de passage</label>
                            <input value="{{ old('taux_de_passage') }}" type="number" name="taux_de_passage"
                                class="form-control @error('taux_de_passage') border-warning @enderror" id="taux_de_passage"
                                placeholder="Taux de passage">
                        </div>
                        @error('taux_de_passage')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <div>
                            <label class="" for="role_du_staff">Role du staff</label>
                            <input value="{{ old('role_du_staff') }}" type="text" name="role_du_staff"
                                class="form-control @error('role_du_staff') border-warning @enderror" id="role_du_staff"
                                placeholder="Role du staff">
                        </div>
                        @error('role_du_staff')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Ajouter
                        membre de staff</button>
                </form>
            </div>
        </div>
    @endcan

@endsection
