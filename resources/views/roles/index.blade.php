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
                    <h4 class="card-title">Liste des roles</h4>
                    @can('create_roles')
                        <a href="{{ route('admin.store_role') }}" class="btn btnAdd">Ajout Role</a>
                    @endcan
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table aria-describedby="mydesc" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                </tr>
                            </thead>
                            @if ($roles->count())
                                @foreach ($roles as $role)
                                    <tbody>
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>

                                                <div class="dropdown">
                                                    <button class="btn btn-danger dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                        style="background: #fff">
                                                        <a href="{{ route('admin.show_role', $role->id) }}"
                                                            class="dropdown-item">
                                                            Detail
                                                        </a>
                                                        <a href="{{ route('admin.show_edit_role', $role->id) }}"
                                                            class="dropdown-item">
                                                            Modifier
                                                        </a>
                                                        @if ($role->name !== 'SUPER_ADMIN')
                                                            <form action="{{ route('admin.destroy_role', $role) }}"
                                                                method="post" class="">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button class="dropdown-item" type="submit">
                                                                    Supprimer
                                                                </button>
                                                            </form>
                                                        @endif
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
                </div>
            </div>
        </div>
    </div>

@endsection
