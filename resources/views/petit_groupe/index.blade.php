@extends('layouts.app')

@section('content')
@auth

<div class="row">
    <div class="col-lg-12">
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Liste de petit groupes ds</h4>
                @can('create_pgs')
                <a href="{{ route('admin.show_create_petit_groupe') }}" class="btn btnAdd">Ajout petit groupe</a>
                @endcan
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <caption class="d-none">Liste de petit groupe</caption>
                        <thead>
                            <tr>
                                <th scope="col">Capitaine</th>
                                <th scope="col">photo</th>
                            </tr>
                        </thead>
                        @if (isset($petit_groupes) && isset($allMembres))
                        @foreach ($petit_groupes as $petit_groupe)
                        @foreach ($allMembres as $membre)
                        @if ($membre->id === $petit_groupe->capitaine)
                        <tbody>
                            <tr>
                                <td>{{ json_decode($membre->info)->nom }}
                                    {{ json_decode($membre->info)->prenom }}</td>
                                <td><img src="{{ $petit_groupe->photo }}" alt="petit groupe" class="img-thumbnail"
                                        style="max-height: 50px; max-width: 50px;"></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                            style="background: #fff">
                                            <a href="{{ route('admin.show_petit_groupe', $petit_groupe->id) }}"
                                                class="dropdown-item">
                                                Detail
                                            </a>
                                            @can('edit_pgs')
                                            <a href="{{ route('admin.show_edit_petit_groupe', $petit_groupe->id) }}"
                                                class="dropdown-item">
                                                Modifier
                                            </a>
                                            @endcan

                                            @can('delete_pgs')
                                            <form action="{{ route('admin.destroy_petit_groupe', $petit_groupe) }}"
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
                        @endif
                        @endforeach
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
    </div>
</div>
@endauth

@endsection