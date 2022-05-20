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
                    <h4 class="card-title">Liste des prospects</h4>
                    <a href="{{ route('admin.store_prospect') }}" class="btn btnAdd">Ajout prospect</a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table aria-describedby="mydesc" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prenom</th>
                                    <th scope="col">Adresse email</th>
                                    <th scope="col">Telephone</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @if ($prospects->count())
                                @foreach ($prospects as $prospect)
                                    <tbody>
                                        <tr>
                                            <td>{{ $prospect->nom }}</td>
                                            <td>{{ $prospect->prenom }}</td>
                                            <td>{{ $prospect->email }}</td>
                                            <td>0{{ $prospect->tel }}</td>
                                            <td>{{ $prospect->type }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-danger dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                        style="background: #fff">
                                                        {{-- <a href="#" class="dropdown-item">
                                                            Detail
                                                        </a> --}}
                                                        <a href="{{ route('admin.edit_prospect', $prospect->id) }}"
                                                            class="dropdown-item">
                                                            Modifier
                                                        </a>
                                                        <form action="{{ route('delete_prospect', $prospect) }}"
                                                            method="post" class="">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button class="dropdown-item" type="submit">
                                                                Supprimer
                                                            </button>
                                                        </form>
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
