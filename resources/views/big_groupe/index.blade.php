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
                    <h4 class="card-title text-normal">Liste des grand groupes</h4>
                    @can('create_ggs')
                        <a href="{{ route('admin.add_big_groupe') }}" class="btn btnAdd">Ajout grand groupe</a>
                    @endcan
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table aria-describedby="mydesc" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Nom&nbsp;du&nbsp;groupe</th>
                                    <th scope="col">Mantra</th>
                                    <th scope="col">Declaration</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Musique chorée</th>
                                    <th scope="col">Video chorée</th>
                                    <th scope="col">Photo&nbsp;du&nbsp;drapeau</th>
                                    <th scope="col">Capitaine</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @if (isset($bigGroupes) && isset($allMembres))
                                @foreach ($bigGroupes as $bigGroupe)
                                    @foreach ($allMembres as $membre)
                                        @if ($membre->id === $bigGroupe->capitaine)
                                            <tbody>
                                                <tr>
                                                    <td>{{ $bigGroupe->type }}</td>
                                                    <td>{{ $bigGroupe->nom }}</td>
                                                    <td>{{ $bigGroupe->mantra }}</td>
                                                    <td>{{ $bigGroupe->declaration }}</td>
                                                    <td><img class="imgBG" src="{{ $bigGroupe->photo }}" alt="">
                                                    </td>
                                                    <td><img class="imgBG" src="{{ $bigGroupe->logo }}" alt="">
                                                    </td>
                                                    <td><audio class="audioC" controls
                                                            src="{{ $bigGroupe->musique_choree }}">
                                                            Votre navigateur ne support pas
                                                            <code>ce type de fichier.</code>
                                                        </audio></td>
                                                    <td>
                                                        <video controls width="150">
                                                            <source src="{{ $bigGroupe->video_choree }}" type="video/avi">
                                                            <source src="{{ $bigGroupe->video_choree }}"
                                                                type="video/gif">
                                                            <source src="{{ $bigGroupe->video_choree }}"
                                                                type="video/mp4">

                                                            Désolé, votre navigateur ne prend pas en charge les vidéos
                                                            intégrées.
                                                        </video>
                                                    </td>
                                                    <td><img class="imgBG" src="{{ $bigGroupe->photo_drapeau }}"
                                                            alt="">
                                                    </td>
                                                    <td>{{ json_decode($membre->info)->nom }}
                                                        {{ json_decode($membre->info)->prenom }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-danger dropdown-toggle" type="button"
                                                                id="dropdownMenu2" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                                style="background: #fff">
                                                                <a href="{{ route('admin.show_grand_groupe', $bigGroupe->id) }}"
                                                                    class="dropdown-item">
                                                                    Detail
                                                                </a>
                                                                @can('edit_ggs')
                                                                    <a href="{{ route('admin.edit_g_group', $bigGroupe->id) }}"
                                                                        class="dropdown-item">
                                                                        Modifier
                                                                    </a>
                                                                @endcan

                                                                @can('delete_ggs')
                                                                    <form action="{{ route('admin.delete_gg', $bigGroupe) }}"
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

                        {{-- {{ $membres->links() }} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
