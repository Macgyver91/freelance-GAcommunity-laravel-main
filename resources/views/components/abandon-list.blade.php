@props(['participants' => $participants, 'abandons' => $abandons])
<div id="accordion4" class="w-100">
    <div class="borderP w-100">
        <div class="card-headers w-100" id="headingThree4">
            <div style="cursor: pointer" class="_txtMN btn btn-link text-left collapsed btn-block" data-toggle="collapse"
                data-target="#collapseThree4" aria-expanded="false" aria-controls="collapseThree4">
                Les abandons
            </div>
        </div>
        <div id="collapseThree4" class="collapse" aria-labelledby="headingThree4" data-parent="#accordion1">
            <div class="px-4 py-4">
                <div class="borderP table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Prénom</th>
                                <th scope="col">Motif d'abandon</th>
                            </tr>
                        </thead>
                        @if ($abandons->count())
                            @foreach ($abandons as $abandon)
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{ route('show_profile', $abandon->membre->id) }}">
                                                {{ json_decode($abandon->membre->info)->nom }}
                                            </a>
                                        </td>
                                        <td>{{ $abandon->motif }}</td>

                                    </tr>

                                </tbody>
                            @endforeach
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="2">Pas de data</td>
                                </tr>
                            </tbody>
                        @endif

                    </table>

                </div>
            </div>

        </div>
    </div>

</div>
