@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liste des membres</h4>
                    @can('create_membres')
                        @can('create_membres')
                            <a href="{{ route('admin.store_membre') }}" class="btn btnAdd">Ajout membre</a>
                        @endcan
                    @endcan
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table aria-describedby="mydesc" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Adresse email</th>
                                    <th scope="col">Genre</th>
                                    <th scope="col">Date&nbsp;de&nbsp;naissance</th>
                                    <th scope="col">Nationalité</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @if ($membres->count())
                                @foreach ($membres as $membre)
                                    <tbody>
                                        <tr>
                                            <td>{{ json_decode($membre->info)->nom }}</td>
                                            <td>{{ json_decode($membre->info)->prenom }}</td>
                                            <td>{{ json_decode($membre->info)->email }}</td>
                                            <td>{{ json_decode($membre->info)->genre }}</td>
                                            <td>{{ json_decode($membre->info)->date_naissance }}</td>
                                            <td>{{ json_decode($membre->info)->nationalite }}</td>
                                            <td>{{ json_decode($membre->info)->telephone }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-danger dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                        style="background: #fff">
                                                        <a href="{{ route('show_profile', $membre->id) }}"
                                                            class="dropdown-item">
                                                            Détail
                                                        </a>
                                                        @can('edit_membres')
                                                            <a href="{{ route('admin.edit_membre', $membre->id) }}"
                                                                class="dropdown-item">
                                                                Modifier
                                                            </a>
                                                        @endcan

                                                        @can('delete_membres')
                                                            <form action="{{ route('delete_membre', $membre) }}"
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
                    {{-- <div class="d-flex justify-content-center">
                    {!! $membres->links() !!}
                </div> --}}
                    {{-- {{ $membres->links() }} --}}
                </div>
            </div>
        </div>
    </div>

@endsection
