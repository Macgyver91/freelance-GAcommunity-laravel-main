@extends('layouts.app')

@section('content')
    <div class="card p-4">
        <div class="card-header">
            <h5>Taux de passage</h5>
        </div>
        <div class="card-content">
            <div class="p-4">
                <div class="borderP tb table-responsive">
                    {{-- @dump( $taux_members_in_event ) --}}
                    <table aria-describedat="tauxPassageTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Place</th>
                                <th scope="col">Rôle</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Téléphone </th>
                                <th scope="col">Taux ind max</th>
                                <th scope="col">Taux ind moy</th>
                                <th scope="col">Taux global max</th>
                                <th scope="col">Taux global moy</th>
                            </tr>
                        </thead>
                        <tbody>
                                @forelse ( $taux_members_in_event as $item )
                                
                                    <tr>
                                        <td>{{ $count += 1 }}<sup>{{ $count==1 ? "er":"eme" }}</sup></td>
                                        <td>Chef</td>
                                        <td>{!! json_decode($item->info)->nom !!}</td>
                                        <td>{!! json_decode($item->info)->prenom !!}</td>
                                        <td>{!! json_decode($item->info)->telephone !!}</td>
                                        <td>{{ ( $item->event_participate / $all_event ) * 100 ."%" }}</td>
                                        <td>{{ ( $item->event_participate / $all_event ) * 100 ."%" }}</td>
                                        <td>{{ ( $item->event_participate / $all_event ) * 100 ."%" }}</td>
                                        <td>{{ ( $item->event_participate / $all_event ) * 100 ."%" }}</td>
                                    </tr>
                                @empty
                                    <td colspan="9"> Aucunes données trouvées </td>
                                @endforelse
                        </tbody>

                    </table>

                </div>
            </div>

            <div id="high_cahrt" style="width:100%; height:400px;"></div>
        </div>
    </div>

    @section('script')
        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script type="text/javascript">

            document.addEventListener('DOMContentLoaded', function () {
                // console.log( {{ $jsonArray }} )
                const chart = Highcharts.chart('high_cahrt', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Statistique'
                    },
                    xAxis: {
                        categories: ['Taux individuel']
                    },
                    yAxis: {
                        title: {
                            text: 'Evènement'
                        }
                    },
                    series: [
                        @foreach ( $taux_members_in_event as $item )
                            {
                                name: '{{ json_decode($item->info)->nom }}',
                                data: [{{ $item->event_participate / $all_event  }}, {{ $item->event_participate / $all_event  }}]
                            },
                        @endforeach

                    ]
                });
            });

        </script>

    @endsection
@endsection
