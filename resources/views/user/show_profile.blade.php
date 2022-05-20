@extends('layouts.app')

@section('content')

<h1>Profile de l'utilisateur n* {{ $user->id }}</h1>
<p>Username: {{ $user->username }}</p>
<p>email: {{ $user->email }}</p>
<p>role: {{ $user->role_user->role_name }}</p>
<p>nom: {{ $user->nom }}</p>
<p>role: {{ $user->prenom }}</p>


<form action="{{ route(" user.edit", $user) }}" method="get" class="">
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