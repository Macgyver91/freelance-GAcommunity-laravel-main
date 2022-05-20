@extends('layouts.app')

@section('content')

    <h1>Petit groupe n* {{ $petit_groupe->id }}</h1>
    <p>Capitaine: {{ $petit_groupe->capitaine }}</p>

    <div class="col-md-12 mb-2">
        <img id="preview-image-before-upload" src="{{ $petit_groupe->photo }}" alt="preview image"
            style="max-height: 250px;">
    </div>
    @can('edit_pgs')
        <form action="{{ route('admin.show_edit_petit_groupe', $petit_groupe->id) }}" method="get" class="">
            @csrf
            <button type="submit" class="text-blue-500">Modifier</button>
        </form>
    @endcan

    <div class="title_txt">Liste des membres appartenant à ce petit groupe</div>


    <div class="tabel-responsive">
        <table aria-describedat="pgtable" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Membre</th>
                </tr>
            </thead>
            @if ($petit_groupe_membres->count())
                @foreach ($petit_groupe_membres as $pg_membre)
                    <tbody>
                        <tr>
                            <td>{{ json_decode($pg_membre->membre->info)->nom }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-add dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2" style="background: #fff">
                                        @can('membre_petit_groupe')
                                            <form action="{{ route('admin.destroy_membre_petit_groupe', $pg_membre) }}"
                                                method="post" class="">
                                                @csrf
                                                @method("DELETE")
                                                <button class="dropdown-item" type="submit">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endcan

                                    </div>
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

    @can('membre_petit_groupe')
        <div class="title_txt">Ajouter des membres à ce petit groupe</div>
        <form action="{{ route('admin.store_membre_petit_groupe', $petit_groupe) }}" method="post" class="">
            @csrf

            <div class="form-group col-12 p-0">
                <div>
                    <p class="mb-1">Ajouter membre</p>
                    <select class="multi-select form-control" name="states[]" multiple="multiple">
                        @foreach ($membres as $membre)
                            <option value="{{ $membre->id }}">{{ json_decode($membre->info)->nom }}</option>
                        @endforeach
                    </select>
                </div>
                @error('membre_id')
                    <div class="text-warning">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Ajouter
                membre</button>
        </form>
    @endcan

    @if (session('message'))
        <div class="">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="">
            {{ session('error') }}
        </div>
    @endif

@endsection
