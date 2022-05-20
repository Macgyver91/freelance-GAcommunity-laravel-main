@extends('layouts.app')

@section('content')
    <div class="card p-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-mbr">
                <a class="nav-link active" id="ipi-tab" data-toggle="tab" href="#ipi" role="tab" aria-controls="ipi"
                    aria-selected="true" style="font-weight: 600">Invitation par individu</a>
            </li>
            <li class="nav-mbr">
                <a class="nav-link" id="ipt-tab" data-toggle="tab" href="#ipt" role="tab" aria-controls="ipt"
                    aria-selected="false" style="font-weight: 600">Invitation par tribu</a>
            </li>
        </ul>
        <div class="tab-content borderP" id="myTabContent">
            <div class="tab-pane fade show active" id="ipi" role="tabpanel" aria-labelledby="ipi-tab">
                <div class="card p-4">
                    <div id="accordion1" class="w-100">
                        <div class="borderP w-100">
                            <div class="card-headers w-100" id="headingThree1">
                                <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block"
                                    data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false"
                                    aria-controls="collapseThree1">
                                    Invitations individu
                                </div>
                            </div>
                            <div id="collapseThree1" class="collapse show" aria-labelledby="headingThree1"
                                data-parent="#accordion1">
                                <div class="px-2 py-4">
                                    <div class="inputYaer">
                                        <select name="year" class="form-control w-auto" id="year">
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                        </select>
                                    </div>
                                    <div class="pt-4">
                                        <div class="borderP tb table-responsive">
                                            <table aria-describedat="invitationTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Place</th>
                                                        <th scope="col">Prénom</th>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Téléphone</th>
                                                        <th scope="col">Nombre d'invitation direct</th>
                                                        <th scope="col">Nombre d'invitation indirect</th>
                                                        <th scope="col">Nombre d'invitation total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if ( $allMembres && !empty($grouped) )

                                                        @foreach ($grouped as $group)

                                                            <tr>
                                                                <td>{{ $a+=1 }}<sup>{{ $a==1 ? "er":"eme" }}</sup></td>
                                                                <td>{{ $group["prenom"] }}</td>
                                                                <td>{{ $group["nom"] }}</td>
                                                                <td>{{ $group["telephone"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                            </tr>

                                                        @endforeach

                                                    @endif

                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                    <div id="pie_chart" style="width: 900px; height: 500px; margin: 0 auto;"></div>

                </div>
            </div>
            <div class="tab-pane fade" id="ipt" role="tabpanel" aria-labelledby="ipt-tab">
                <div class="card p-4">
                    <div id="accordion" class="w-100">
                        <div class="borderP w-100">
                            <div class="card-headers w-100" id="headingThree">
                                <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block"
                                    data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false"
                                    aria-controls="collapseThree1">
                                    Invitation tribu
                                </div>
                            </div>
                            <div id="collapseThree" class="collapse show" aria-labelledby="headingThree1"
                                data-parent="#accordion">
                                <div class="px-2 py-4">
                                    <div class="inputYaer">
                                        <select name="year" id="year">
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                        </select>
                                    </div>
                                    <div class="pt-4">
                                        <div class="borderP tb table-responsive">
                                            <table aria-describedat="invitationTabletribu" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Place</th>
                                                        <th scope="col">Tribu</th>
                                                        <th scope="col">NTID</th>
                                                        <th scope="col">NTII</th>
                                                        <th scope="col">NTOT</th>
                                                        <th scope="col">NTIDPP</th>
                                                        <th scope="col">NTIIPP</th>
                                                        <th scope="col">NTOTPP</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ( $allMembres && !empty($grouped) )
                                                        @foreach ($grouped as $group)
                                                            {{-- @dump( $grouped->sortBy($group["count_invite"]) ) --}}
                                                            <tr>
                                                                <td>{{ $count+=1 }} <sup>{{ $count==1 ? "er":"eme" }}</sup></td>
                                                                
                                                                <td>Tribu</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                                <td>{{ $group["count_invite"] }}</td>
                                                            </tr>

                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="pt-4 pl-4">
                                            <ul>
                                                <li><b>NTID:</b> <span>Nombre Total d'Invitation en Direct</span> </li>
                                                <li><b>NTII:</b> <span>Nombre Total d'Invitation en Indirect</span></li>
                                                <li><b>NTOT:</b> <span>Nombre Total d'Invitation</span></li>
                                                <li><b>NTIDPP:</b> <span>Nombre Total d'Invitation Direct par Personne de la
                                                        tribu</span></li>
                                                <li><b>NTIIPP:</b> <span>Nombre Total d'Invitation Indirect par Personne de
                                                        la
                                                        tribu</span>
                                                </li>
                                                <li><b>NTOTPP:</b> <span>Nombre Totatl d'Invitation par Personne de la
                                                        Tribu</span></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">

            document.addEventListener('DOMContentLoaded', function () {

                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                    var data = google.visualization.arrayToDataTable([
                        ["Invitation", "Nombre d'invitation total"],
                        @if ( $allMembres && !empty($grouped) )
                            @foreach ($grouped as $group)
                                [`{{ $group["prenom"] .' '. $group["nom"] }}`, {{ $group["count_invite"] }}],
                            @endforeach
                        @endif
                    ]);

                    var options = {
                        title: 'Invitations individu',
                        is3D: true,
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));

                    chart.draw(data, options);

                }

            });

        </script>

    @endsection

@endsection
