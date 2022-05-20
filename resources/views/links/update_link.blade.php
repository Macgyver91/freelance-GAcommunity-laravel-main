@extends('layouts.app')

@section('content')
<div class="row row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="text-align: center ">
                <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modification de lien
                </h4>
            </div>
            <div class="card-body">
                <div class="create-event-form">
                    <form action="{{ route('admin.update_link', $link) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="sr-only" for="type_lien_id">Type de lien</label>
                                <select id="type_lien_id" name="type_lien_id" class="form-control  @error('type_lien_id')
                                    border-warning @enderror">
                                    <option value="">Selectionnez le type de lien</option>
                                    @foreach ($type_liens as $tl)
                                    <option {{ $link->type_lien_id === $tl->id ? 'selected' : '' }} value="{{ $tl->id
                                        }}">{{ $tl->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="" for=" membre_id">Membre</label>
                                <select id="membre_id" name="membre_id" class="form-control  @error('membre_id')
                                border-warning @enderror">
                                    {{-- <option value="{{ $link->membre_id }}">{{ $link->membre_id }}</option> --}}
                                    @foreach ($membres as $membre)
                                    <option {{ $link->membre_id === $membre->id ? "selected" : '' }} value="{{
                                        $membre->id }}">{{ json_decode($membre->info)->nom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="" for="prospect_id">Prospect</label>
                                <select id="prospect_id" name="prospect_id" class="form-control @error('prospect_id')
                                border-warning @enderror">
                                    @foreach ($membres as $membre)
                                    <option {{ $link->prospect_id === $membre->id ? "selected" : '' }} value="{{
                                        $membre->id }}">{{ json_decode($membre->info)->nom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn-add btn btn-primary btn-lg w-100">Valider</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection