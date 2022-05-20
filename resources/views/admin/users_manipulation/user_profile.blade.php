@extends('layouts.app')

@section('content')
    <div class="row page-titles mx-0">
        <div class="col-sm-6 p-md-0">
            <div class="breadcrumb-range-picker">
                <span><i class="icon-calender"></i></span>
                <span class="ml-1">Bienvenue</span>
            </div>
        </div>
        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Utilisateur</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
            </ol>
        </div>
    </div>
    {{-- {{ dd(auth()->user()) }} --}}
    <div class="row">
        <div class="col-lg-4 col-md-5 col-xxl-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center mb-4">
                        <div class="imgProfilUser">
                            {{ substr(auth()->user()->prenom, 0, 1) }}
                        </div>
                        <div class="media-body">
                            <h5 class="mb-0">{{ auth()->user()->nom }}</h5>
                            <h4 class="mb-0">{{ auth()->user()->prenom }}</h4>
                            <p class="text-muted mb-0">{{ auth()->user()->getRoleNames() }}</p>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col">
                            <div class="card-profile border-0 text-center">
                                <span class="mb-1 text-primary"><i class="icon-people"></i></span>
                                <h3 class="mb-0">263</h3>
                                <p class="text-muted px-4">Following</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card-profile border-0 text-center">
                                <span class="mb-1 text-warning"><i class="icon-user-follow"></i></span>
                                <h3 class="mb-0">263</h3>
                                <p class="text-muted">Followers</p>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('admin.edit_user', auth()->user()->id) }}"
                                class="btn btn-add px-5">Modifier</a>
                        </div>
                    </div>

                    <h5>Apropos de <span class="text-dark">{{ auth()->user()->prenom }}</span></h5>
                    <hr>

                    <ul class="card-profile__info">
                        <li><strong class="text-dark">Nom</strong> <span>{{ auth()->user()->nom }}</span></li>
                        <li><strong class="text-dark">Prenom</strong> <span>{{ auth()->user()->prenom }}</span></li>
                        <li><strong class="text-dark">Role</strong> <span>{{ auth()->user()->getRoleNames() }}</span>
                        </li>
                        <li><strong class="text-dark">Nom d'utilisateur</strong>
                            <span>{{ auth()->user()->username }}</span>
                        </li>
                        <li><strong class="text-dark">Email</strong> <span>{{ auth()->user()->email }}</span></li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
@endsection
