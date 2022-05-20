<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GA-Community</title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('icons/font-awesome-old/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/vendor/chartist/css/chartist.min.css') }}">

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('js/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('js/vendor/select2/css/select2.min.css') }}">
</head>

<body>
    @auth
        <div id="preloader">
            <div class="spinner">
                <div class="spinner-a"></div>
                <div class="spinner-b"></div>
            </div>
        </div>
        <div id="main-wrapper">

            <div class="nav-header">
                <a href="{{ route('admin.dashboard') }}" class="brand-logo">
                    <span class="logo-abbr">G.A</span>
                    {{-- <img class="logo-abbr logoS" src="{{ asset('logo/ga.png') }}" alt=""> --}}
                    {{-- <span class="logo-compact">Greatness Académie</span> --}}
                    <span class="brand-title text-uppercase">Greatness Académie</span>
                    {{-- <img class="brand-title logo" src="{{ asset('logo/ga.png') }}" alt=""> --}}
                </a>

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><em class="icon-menu"></em></span>
                    </div>
                </div>
            </div>

            <div class="header">
                <div class="header-content">
                    <nav class="navbar navbar-expand">
                        <div class="header-left">
                            <div class="nav-item dropdown search_bar">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <em class="mdi mdi-magnify"></em>
                                </a>
                                <div class="dropdown-menu">
                                    <form class="form-inline">
                                        <input class="form-control" type="search" placeholder="Search"
                                            aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse justify-content-end">

                            <ul class="navbar-nav header-right">
                                <li class="nav-item dropdown notification_dropdown">
                                    <a class="nav-link" href="#" role="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <em class="mdi mdi-bell"></em>
                                        <span class="badge badge-primary">3</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-header">
                                            <h5 class="notification_title">Notifications</h5>
                                        </div>
                                        <ul class="list-unstyled">
                                            <li class="media dropdown-item">
                                                <span class="text-primary"><em
                                                        class="mdi mdi-chart-areaspline mr-3"></em></span>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>New order has been received</h5>
                                                        </div>
                                                        <p class="m-0">2 hours ago</p>
                                                    </a>
                                                    <em class="fa fa-angle-right"></em>
                                                </div>
                                            </li>
                                            <li class="media dropdown-item">
                                                <span class="text-success"><em class="mdi mdi-chart-pie mr-3"></em></span>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>New customer is registered</h5>
                                                        </div>
                                                        <p class="m-0">3 hours ago</p>
                                                    </a>
                                                    <em class="fa fa-angle-right"></em>
                                                </div>
                                            </li>
                                            <li class="media dropdown-item">
                                                <span class="text-warning"><em
                                                        class="mdi mdi-file-document mr-3"></em></span>
                                                <div class="media-body">
                                                    <a href="#">
                                                        <div class="d-flex justify-content-between">
                                                            <h5>New file has been uploaded</h5>
                                                        </div>
                                                        <p class="m-0">3 hours ago</p>
                                                    </a>
                                                    <em class="fa fa-angle-right"></em>
                                                </div>
                                            </li>
                                        </ul>
                                        <a class="all-notification" href="#">All Notifications</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown header-profile">
                                    <div class="nav-link imgProfil" style="cursor: pointer" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ substr(auth()->user()->username, 0, 1) }}
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-profile-header profileH">
                                            <div class="imgProfil">
                                                {{ substr(auth()->user()->username, 0, 1) }}
                                            </div>
                                            <span class="avatar-name ml-2">{{ auth()->user()->username }}</span>
                                        </div>
                                        <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                            <em class="mdi mdi-account"></em>
                                            <span>Profile</span>
                                        </a>


                                        @auth
                                            <form action="{{ route('user.logout') }}" method="post">
                                                @csrf
                                                <button class="dropdown-item" type="submit">
                                                    <em class="mdi mdi-power"></em>Se déconnecter
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="quixnav">
                <div class="quixnav-scroll">
                    <ul class="metismenu" id="menu">
                        <li class="nav-label">Navigation</li>
                        @if (auth()->user()->hasRole('SUPER_ADMIN') ||
        auth()->user()->hasRole('ADMIN'))
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><em
                                        class="mdi mdi-home mr-1"></em><span class="nav-text">Tableau de
                                        bord</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="{{ route('admin.dashboard') }}">Liste des utilisateurs</a></li>
                                    @if (auth()->user()->hasRole('SUPER_ADMIN'))
                                        <li><a href="{{ route('admin.all_roles') }}">Gestion de Role</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @auth
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                    <em class="mdi mdi-eventbrite mr-1"></em><span class="nav-text">Evenement</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="{{ route('admin.all_events') }}">Liste des evenements</a></li>

                                </ul>
                            </li>

                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><em
                                        class="mdi mdi-account-multiple mr-1"></em><span
                                        class="nav-text">Membre</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="{{ route('admin.membre') }}">Liste des membres</a></li>
                                    <li><a href="{{ route('admin.big_groupe') }}">Grand group</a></li>
                                    <li><a href="{{ route('admin.all_petit_groupes') }}">Petit Group</a></li>
                                    <li><a href="{{ route('admin.all_staffs') }}">Groupe de staff</a></li>
                                </ul>
                            </li>

                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><em
                                        class="mdi mdi-chart-areaspline mr-1"></em><span
                                        class="nav-text">Statistique</span></a>
                                <ul aria-expanded="false">
                                    <li><a href="{{ route('admin.stat_membre_tribu') }}">Invitation</a></li>
                                    <li><a href="{{ route('admin.tauxPassage') }}">Taux de passage</a></li>
                                </ul>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        @endauth


        @auth
            <div class="content-body">
                <!-- row -->
                <div class="container-fluid">
                    @yield('content')

                </div>
            </div>
        @endauth
        @guest
            <div>
                @yield('content')

            </div>
        @endguest

    </div>

    <script src="{{ asset('js/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/vendor/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/vendor/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/chartist-init.js') }}"></script>
    <script src="{{ asset('js/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('/js/plugins-init/chartjs-init.js') }}"></script>
    <!-- Here is navigation script -->
    <script src="{{ asset('js/vendor/quixnav/quixnav.min.js') }}"></script>
    <script src="{{ asset('js/quixnav-init.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!--removeIf(production)-->
    <!-- Demo scripts -->
    <script src="{{ asset('js/styleSwitcher.js') }}"></script>
    <!--endRemoveIf(production)-->

    <!-- Daterange picker library -->
    <script src="{{ asset('js/vendor/circle-progress/circle-progress.min.js') }}"></script>

    <script src="{{ asset('js/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/dashboard-1.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('js/vendor/select2/js/select2.full.min.js') }}"></script>
    <!-- Select 2 init -->
    <script src="{{ asset('js/plugins-init/select2-init.js') }}"></script>
    <script src="{{ asset('js/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('script')
</body>

</html>
<script>
    $(document).ready(function(e) {
                $('#photo').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#preview-image-before-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });
                $('#logo').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#preview-image-before-upload1').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });
                $('#photo_drapeau').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#preview-image-before-upload2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });
                $('#musique_choree').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#prev-audio').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });

                $('#video_choree').change(function() {

                    let reader = new FileReader();

                    reader.onload = (e) => {

                        $('#prev-video').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(this.files[0]);

                });
        }
    );
</script>
