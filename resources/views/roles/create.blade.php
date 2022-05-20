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
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Creation de role
                    </h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">

                        <form action="{{ route('admin.store_role') }}" method="POST">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="sr-only" for="name">Role</label>
                                    <input value="{{ old('name') }}" type="text" name="name"
                                        class="form-control @error('name') border-warning @enderror" id="name"
                                        placeholder="Le role">
                                </div>
                                @error('name')
                                    <div class="text-warning">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                            <div class="pt-3">

                                <div class="pt-4">
                                    <div class="form-group col-12">
                                        <label class="sr-only" for="type"></label>
                                        <div class="table-responsive">
                                            <table aria-describedat="roleTable" id="example" class="display"
                                                style="min-width: 845px">
                                                <thead>
                                                    <th scope="role">Permissions</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($permissions as $permission)

                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="permission[]"
                                                                    value="{{ $permission->name }}">
                                                                {{ $permission->name }}
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
