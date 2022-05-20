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
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-5 col-xxl-4 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="media align-items-center mb-4">
                        <div class="imgProfilUser">
                            {{ substr($user->prenom, 0, 1) }}
                        </div>
                        <div class="media-body">
                            <h5 class="mb-0">{{ $user->nom }}</h5>
                            <h4 class="mb-0">{{ $user->prenom }}</h4>
                            <p class="text-muted mb-0">{{ $user->getRoleNames() }}</p>
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
                            <a href="{{ route('admin.edit_user', $user->id) }}" class="btn btn-add px-5">Modifier</a>
                        </div>
                    </div>

                    <h5>Apropos de <span class="text-dark">{{ $user->prenom }}</span></h5>
                    <hr>

                    <ul class="card-profile__info">
                        <li><strong class="text-dark">Nom</strong> <span>{{ $user->nom }}</span></li>
                        <li><strong class="text-dark">Prenom</strong> <span>{{ $user->prenom }}</span></li>
                        <li><strong class="text-dark">Role</strong> <span>{{ $user->getRoleNames() }}</span></li>
                        <li><strong class="text-dark">Nom d'utilisateur</strong> <span>{{ $user->username }}</span>
                        </li>
                        <li><strong class="text-dark">Email</strong> <span>{{ $user->email }}</span></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-lg-8 col-md-7 col-xxl-8 col-xl-9">


            <div class="card comments_section">
                <div class="card-body">
                    <div class="media media-reply">

                    </div>

                    <div class="media media-reply">

                    </div>

                    <div class="media media-reply">

                        <div class="media-body">
                            <div class="d-lg-flex justify-content-between mb-2">
                                <h5 class="mb-sm-0 media-reply__username">{{ $user->username }} <small
                                        class="text-muted ml-sm-3">{{ $user->created_at }}</small></h5>
                                <div class="media-reply__link mt-2 mt-lg-0">
                                    <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-up"></i></button>
                                    <button class="btn btn-transparent p-0 mr-3"><i class="fa fa-thumbs-down"></i></button>
                                    <button class="btn btn-transparent p-0 font-weight-bold">Reply</button>
                                </div>
                            </div>

                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.
                                Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                                ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
