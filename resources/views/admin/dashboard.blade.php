@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-12">

        <div class="card">
            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            {{-- Header --}}
            <div class="card-header">
                <h3 class="text-center text-success">List des utilisateurs</h3>
                <a href="{{ route('admin.create_user') }}" class="btn btnAdd">Ajout utilisateurs</a>
            </div>
            {{-- end Header --}}


            <div class="card-body">

                <div class="tabel-responsive">
                    <table class="table table-hover">
                        <caption class="d-none">Liste des utilisateurs</caption>
                        <thead>
                            <tr>
                                <th scope="col">Nom d'utilisateur</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Compte confirmé ?</th>
                                {{-- <th scope="col">Date_de_naissance</th>
                                <th scope="col">Nationalite</th>
                                <th scope="col">Telephone</th>
                                <th scope="col">Action</th> --}}
                            </tr>
                        </thead>
                        {{-- {{ dd($role_users[1]) }} --}}
                        @if ($users->count())
                        @foreach ($users as $user)
                        <tbody>
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleNames() }}</td>
                                <td>{{ isset($user->email_verified_at) ? 'Oui' : 'Non' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                            style="background: #fff">
                                            <a href="{{ route('admin.show_user', $user->id) }}" class="dropdown-item">
                                                Detail
                                            </a>
                                            @can('edit_users')
                                            <a href="{{ route('admin.edit_user', $user->id) }}" class="dropdown-item">
                                                Modifier
                                            </a>
                                            @endcan
                                            @can('delete_users')
                                            <form action="{{ route('admin.destroy_user', $user) }}" method="post"
                                                class="">
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

                    {{-- {{ $membres->links() }} --}}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection