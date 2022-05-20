@extends('layouts.app')

@section('content')


{{-- Start --}}
<div class="row row justify-content-center">
    <div class="col-lg-6">
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
            <div class="card-header">
                <h4 class="card-title" style="text-transform: uppercase; margin: auto">Creation de l'utilisateur</h4>
            </div>
            <div class="card-body">
                <div class="create-event-form">
                    <form action="{{ route('admin.store_user') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="sr-only" for="email">Adresse email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') border-warning @enderror w-100" id="email"
                                    placeholder="Adresse email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <div class="text-warning">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="sr-only" for="roles">Role</label>
                                <select id="roles" name="roles" class="form-control" @error('roles') border-warning
                                    @enderror>
                                    @foreach ($role_users as $role_user)
                                    <option value="{{ $role_user }}">{{ "$role_user" }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection