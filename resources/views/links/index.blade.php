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
                    {{-- <a href="{{ route('admin.create_links') }}" class="btn btnAdd">Creation lien</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table aria-describedby="mydesc" class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">id du Prospect</th>
                                    <th scope="col">id du Membre</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @if ($links->count())
                                @foreach ($links as $link)
                                    <tbody>
                                        <tr>
                                            <td>{{ $link->type_lien->name }}</td>
                                            <td>{{ $link->prospect_id }}</td>
                                            <td>{{ $link->membre_id }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-danger dropdown-toggle" type="button"
                                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2"
                                                        style="background: #fff">
                                                        <a href="{{ route('admin.edit_link', $link->id) }}"
                                                            class="dropdown-item">
                                                            Modifier
                                                        </a>
                                                        <form action="
                                                                                        {{ route('delete_link', $link) }}
                                                                                        " method="post"
                                                            class="">
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

                        {{-- {{ $membres->links() }} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
