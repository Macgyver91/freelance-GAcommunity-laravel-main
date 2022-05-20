@extends('layouts.app')

@section('content')
    <div class="row row justify-content-center">
        <div class="col-lg-12">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header" style="text-align: center ">
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modification de role
                    </h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.update_role', $role->id) }}" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="name">Nom</label>
                                    <input value="{{ $role->name }}" type="text" name="name"
                                        class="form-control @error('name') border-warning @enderror" id="name"
                                        placeholder="LE nom du role">
                                </div>
                                @error('name')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="type">Permissions</label>
                                    <ul class="roleT">
                                        @foreach ($permissions as $permission)

                                            <li><input {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                    type="checkbox" name="permission[]" value="{{ $permission->name }}">
                                                {{ $permission->name }}</li>

                                        @endforeach
                                    </ul>

                                </div>
                            </div>

                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>

                        </form>
                        <form action="{{ route('admin.revoke_all_permissions', $role->id) }}" method="post"
                            class="">
                            @csrf
                            @method("DELETE")
                            <button class="btn-add btn btn-secondary btn-lg w-100 mt-4">
                                Supprimer toutes les roles
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
