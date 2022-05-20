@extends('layouts.app')

@section('content')

<div class="authincation h-100">
  <div class="container h-100">
    <div class="row justify-content-center vh-100 align-items-center">
      <div class="col-md-10">
        <div class="authincation-content">
          <div class="row no-gutters">
            <div class="col-xl-6">
              <div class="welcome-content">
                <div class="brand-logo">
                  <a href="{{ route('home') }}">GA Community</a>
                </div>
              </div>
            </div>
            <div class="col-xl-6">
              <div class="auth-form">
                <h4 class="text-center mb-4">Resend define password link ?</h4>
                <form action="{{ route('define_password.resend') }}" method="post">

                  @csrf

                  @if (session('status'))
                  <div class="alert alert-success mt-2" role="alert">
                    {{ session('status') }}
                  </div>
                  @endif

                  <div class="form-group">
                    <label for="email"><strong>Email</strong></label>
                    <input type="email" name="email" class="form-control" value="{{ old(" email") }}"
                      placeholder="Votre email">
                    @error('email')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">Resend Password Define
                      Link</button>

                    @error('error')
                    <div class="alert alert-danger mt-2" role="alert">
                      {{ $message }}
                      </d>
                      @enderror
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection