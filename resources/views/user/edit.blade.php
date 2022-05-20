@extends('layouts.app')

@section('content')

<h1>Edit user by user</h1>

<form action="{{ route("user.update", $user) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="">
    <label for="username" class="">Username</label>
    <input type="text" name="username" id="username" placeholder="the user's username" 
    class="" 
    value="{{ $user->username }}" />

    @error('username')
        <div class="">
          {{ $message }}
        </div>
    @enderror
  </div>

  <div class="">
    <label for="email" class="">Email</label>
    <input type="email" name="email" id="email" placeholder="the user's email" 
    class="" 
    value="{{ $user->email }}" />

    @error('email')
        <div class="">
          {{ $message }}
        </div>
    @enderror
  </div>

  <div>
    <button type="submit" class="">
      Update
    </button>
  </div>

@if (session('error'))
  <div class="">
    {{ session('error') }}
  </div>
@endif
</form>

@endsection