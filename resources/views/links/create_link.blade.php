@extends('layouts.app')

@section('content')
    <div class="row row justify-content-center">
        <div class="col-lg-6">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header" style="text-align: center ">
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Creation de lien
                    </h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.add_link') }}" method="POST">
                            @csrf

                            <div class="py-4">
                                <a href="#" data-toggle="modal" data-target="#modalCenter"
                                    class="btn btn-add btn-block">Creer un
                                    type
                                    de lien</a>
                            </div>
                            <h4 class="text-center">OU</h4>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="" for="type_lien_id">Type de lien</label>
                                    <select id="type_lien_id" name="type_lien_id"
                                        class="form-control  @error('type_lien_id')
                                    border-warning @enderror">
                                        <option value="">Selectionnez le lien</option>
                                        @foreach ($type_liens as $tl)
                                            <option value="{{ $tl->id }}">{{ $tl->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label class="" for="prospect_id">Membre</label>
                                    <select id="prospect_id" name="prospect_id"
                                        class="form-control  @error('prospect_id')
                                    border-warning @enderror">
                                        <option value="">Selectionnez le membre</option>
                                        @foreach ($membres as $membre)
                                            @if ($membre->id !== $membreLien->id)
                                                <option value="{{ $membre->id }}">
                                                    {{ json_decode($membre->info)->nom }}
                                                    {{ json_decode($membre->info)->prenom }}
                                                </option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" value="{{ $membreLien->id }}" name="membre_id">

                            <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="modalCenter">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Type de lien</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <form id="myForm" action="{{ route('admin.store_type_lien') }}" method="post" enctype='application/json'>
                    @csrf
                    <div class="modal-body">
                        {{-- <input type="hidden" name="membre_id" value="" id="membre_id_input" class="membre_id_input"> --}}
                        <div class="form-group col-12">
                            <div>
                                <label class="" for="name">Type de lien</label>
                                <input value="{{ old('name') }}" type="text" name="name"
                                    class="form-control @error('name') border-warning @enderror" id="name"
                                    placeholder="Type du lien">
                            </div>
                            @error('motif')
                                <div class="text-warning">
                                    Le champ type du lien est obligatoir!
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
