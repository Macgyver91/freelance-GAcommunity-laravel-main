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
                        <h4 class="card-Title">Liste de groupe de staff</h4>
                        @can('create_staffs')
                            <a href="{{ route('admin.show_create_staff') }}" class="btn btnAdd">Nouveau groupe de staff</a>
                        @endcan
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Mantra</th>
                                        <th scope="col">Logo</th>
                                        <th scope="col">type</th>
                                        <th scope="col">photo</th>
                                    </tr>
                                </thead>
                                @if ($staffs->count())
                                    @foreach ($staffs as $staff)
                                        <tbody>
                                            <tr>
                                                <td>{{ $staff->nom }}</td>
                                                <td>{{ $staff->mantra }}</td>
                                                <td><img src="{{ $staff->logo }}" alt="logo staff" class="img-thumbnail"
                                                        style="max-height: 50px; max-width: 50px;"></td>
                                                <td>{{ $staff->type }}</td>
                                                <td><img src="{{ $staff->photo }}" alt="staff photo" class="img-thumbnail"
                                                        style="max-height: 50px; max-width: 50px;"></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                            style="background: #fff">
                                                            <a href="{{ route('admin.show_staff', $staff->id) }}"
                                                                class="dropdown-item">
                                                                Détail
                                                            </a>
                                                            @can('edit_staffs')
                                                                <a href="{{ route('admin.show_edit_staff', $staff->id) }}"
                                                                    class="dropdown-item">
                                                                    Modifier
                                                                </a>
                                                            @endcan

                                                            @can('delete_staffs')
                                                                <form action="{{ route('admin.destroy_staff', $staff) }}"
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

                    </div>
                </div>
            </div>
        </div>
    @endauth

@endsection
