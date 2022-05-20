@extends('layouts.app')

@section('content')

<h1>Role n* {{ $role->id }}</h1>
<p>nom: {{ $role->name }}</p>

<p>Permissions: </p>
<ul>
  @foreach ($rolePermissions as $permission)
  <li>* {{$permission->name}}</li>
  @endforeach
</ul>



<form action="{{ route('admin.show_edit_role', $role->id) }}" method="get" class="">
  @csrf
  <button type="submit" class="text-blue-500">Edit</button>
</form>

@if (session('message'))
<div class="">
  {{ session('message') }}
</div>
@endif

@if (session('error'))
<div class="">
  {{ session('error') }}
</div>
@endif

@endsection