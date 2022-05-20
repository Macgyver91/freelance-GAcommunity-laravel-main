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
                        <h3 class="text-center text-success">Liste des evenements</h3>
                        @can('create_events')
                            <a href="{{ route('admin.show_create_event') }}" class="btn btnAdd">Ajouter Evenement</a>
                        @endcan
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table aria-describedby="mydesc" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Type</th>
                                        <th scope="col">Ville</th>
                                        <th scope="col">Centre</th>
                                        <th scope="col">Date debut</th>
                                        <th scope="col">Lieu</th>
                                        <th scope="col">Adresse</th>
                                        <th scope="col">Coach</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                @if ($evenements->count())
                                    @foreach ($evenements as $event)
                                        <tbody>
                                            <tr>
                                                <td>{{ $event->type }}</td>
                                                <td>{{ $event->ville }}</td>
                                                <td>{{ $event->centre }}</td>
                                                <td>{{ $event->date_debut }}</td>
                                                <td>{{ $event->lieu }}</td>
                                                <td>{{ $event->adresse }}</td>
                                                <td>{{ $event->coach }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-danger dropdown-toggle" type="button"
                                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                            style="background: #fff">
                                                            <a href="{{ route('admin.show_event', $event->id) }}"
                                                                class="dropdown-item">
                                                                Détail
                                                            </a>
                                                            @can('edit_events')
                                                                <a href="{{ route('admin.show_edit_event', $event->id) }}"
                                                                    class="dropdown-item">
                                                                    Modifier
                                                                </a>
                                                            @endcan

                                                            @can('delete_events')
                                                                <form action="{{ route('admin.destroy_event', $event) }}"
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
