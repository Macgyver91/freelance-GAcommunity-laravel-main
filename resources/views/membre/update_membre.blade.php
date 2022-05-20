@extends('layouts.app')

@section('content')
    <div class="row row justify-content-center">
        <div class="col-lg-12">
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
                <div class="card-header">
                    <h4 class="card-title" style="text-transform: uppercase; margin: auto">Modifiction de membre</h4>
                </div>
                <div class="card-body">
                    <div class="create-event-form">
                        <form action="{{ route('admin.update_membre', $oneMembre) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="status">Status</label>
                                        <select id="status" name="status"
                                            class="form-control @error('status') border-warning
                                    @enderror">
                                            <option value="{{ $oneMembre->status }}">{{ $oneMembre->status }}</option>
                                            <option value="Membre">Membre</option>
                                            <option value="Prospect">Prospect</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <div class="text-warning">
                                            Le champs status est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="nom">Nom</label>
                                        <input value="{{ json_decode($oneMembre->info)->nom }}" type="text" name="nom"
                                            class="form-control @error('nom') border-warning @enderror" id="nom"
                                            placeholder="Votre nom">
                                    </div>
                                    @error('nom')
                                        <div class="text-warning">
                                            Le champs nom est obligatoire
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="prenom">Prénom</label>
                                        <input value="{{ json_decode($oneMembre->info)->prenom }}" type="text"
                                            name="prenom" class="form-control @error('prenom') border-warning @enderror"
                                            id="prenom" placeholder="Votre prénom">
                                    </div>
                                    @error('prenom')
                                        <div class="text-warning">
                                            Le champs prenom est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="email">Email</label>
                                        <input value="{{ json_decode($oneMembre->info)->email }}" type="email"
                                            name="email" class="form-control @error('email') border-warning @enderror w-100"
                                            id="email" placeholder="Votre adresse email">
                                    </div>
                                    @error('email')
                                        <div class="text-warning">
                                            Le champs email est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="date_naissance">Date de naissance</label>
                                        <input value="{{ json_decode($oneMembre->info)->date_naissance }}" type="date"
                                            name="date_naissance"
                                            class="form-control @error('date_naissance') border-warning @enderror w-100"
                                            id="date_naissance" placeholder="Votre date de naissance">
                                    </div>
                                    @error('date_naissance')
                                        <div class="text-warning">
                                            Le champs date de naissance est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label class="" for="genre">Genre</label>
                                    <select id="genre" name="genre"
                                        class="form-control  @error('genre') border-warning
                                    @enderror">
                                        <option value="{{ json_decode($oneMembre->info)->genre }}">
                                            {{ json_decode($oneMembre->info)->genre }}</option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="nationalite">Nationalité</label>
                                        <input value="{{ json_decode($oneMembre->info)->nationalite }}" type="text"
                                            name="nationalite"
                                            class="form-control @error('nationalite') border-warning @enderror w-100"
                                            id="nationalite" placeholder="Votre Nationalite">
                                    </div>
                                    @error('nationalite')
                                        <div class="text-warning">
                                            Le champs nationalite est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="telephone">Téléphone</label>
                                        <input value="{{ json_decode($oneMembre->info)->telephone }}" type="text"
                                            name="telephone"
                                            class="form-control @error('telephone') border-warning @enderror w-100"
                                            id="telephone" placeholder="Votre numero de Téléphone">
                                    </div>
                                    @error('telephone')
                                        <div class="text-warning">
                                            Le champs Téléphone est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="civil_state">Etat civil</label>
                                        <input value="{{ json_decode($oneMembre->info)->civil_state }}" type="text"
                                            name="civil_state"
                                            class="form-control @error('civil_state') border-warning @enderror w-100"
                                            id="civil_state" placeholder="Etat civil">
                                    </div>
                                    @error('civil_state')
                                        <div class="text-warning">
                                            Le champs etat civil est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="metier">Metier</label>
                                        <input type="text" value="{{ json_decode($oneMembre->info)->metier }}"
                                            name="metier"
                                            class="form-control @error('metier') border-warning @enderror w-100" id="metier"
                                            placeholder="Votre metier">
                                    </div>
                                    @error('metier')
                                        <div class="text-warning">
                                            Le champs metier est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="talents">Talents</label>
                                        <input value="{{ json_decode($oneMembre->info)->talents }}" type="text"
                                            name="talents"
                                            class="form-control @error('talents') border-warning @enderror w-100"
                                            id="talents" placeholder="Votre talentse">
                                    </div>
                                    @error('talents')
                                        <div class="text-warning">
                                            Le champs talents est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label class="" for="ange">Ange</label>
                                    <select id="ange" name="ange"
                                        class="form-control @error('ange') border-warning
                                    @enderror">
                                        <option value="{{ $oneMembre->id }}">
                                            {{ json_decode($oneMembre->info)->ange }}
                                        </option>
                                        @foreach ($AllMembres as $membre)
                                            <option value="{{ $membre->id }}">
                                                {{ json_decode($membre->info)->nom }}
                                                {{ json_decode($membre->info)->prenom }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('ange')
                                        <div class="text-warning">
                                            Le champs ange est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="origin_invi">Origine invitation</label>
                                        <input value="{{ json_decode($oneMembre->info)->origin_invi }}" type="text"
                                            name="origin_invi"
                                            class="form-control @error('origin_invi') border-warning @enderror w-100"
                                            id="origin_invi" placeholder="Origine invitation">
                                    </div>
                                    @error('origin_invi')
                                        <div class="text-warning">
                                            Le champs Origine invitation est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="contact_perso">Personnel a contacter</label>
                                        <input value="{{ json_decode($oneMembre->info)->contact_perso }}" type="text"
                                            name="contact_perso"
                                            class="form-control @error('contact_perso') border-warning @enderror w-100"
                                            id="contact_perso" placeholder="Votre Personnel a contacter">
                                    </div>
                                    @error('contact_perso')
                                        <div class="text-warning">
                                            Le champs Personnel a contacter est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="sautQDanse">Saut Quantique danse</label>
                                        <input value="{{ json_decode($oneMembre->info)->sautQDanse }}" type="text"
                                            name="sautQDanse"
                                            class="form-control @error('sautQDanse') border-warning @enderror w-100"
                                            id="sautQDanse" placeholder="Saut Quantique danse">
                                    </div>
                                    @error('sautQDanse')
                                        <div class="text-warning">
                                            Le champs Saut Quantique danse est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="musicSautQ">Musique saut quantique</label>
                                        <input value="{{ json_decode($oneMembre->info)->musicSautQ }}" type="text"
                                            name="musicSautQ"
                                            class="form-control @error('musicSautQ') border-warning @enderror w-100"
                                            id="musicSautQ" placeholder="Musique saut quantique">
                                    </div>
                                    @error('musicSautQ')
                                        <div class="text-warning">
                                            Le champs Musique saut quantique est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="musicVol">Musique vol</label>
                                        <input value="{{ json_decode($oneMembre->info)->musicVol }}" type="text"
                                            name="musicVol"
                                            class="form-control @error('musicVol') border-warning @enderror w-100"
                                            id="musicVol" placeholder="Musique vol">
                                    </div>
                                    @error('musicVol')
                                        <div class="text-warning">
                                            Le champs musique vol est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="contrat">Contrat</label>
                                        <input value="{{ json_decode($oneMembre->info)->contrat }}" type="text"
                                            name="contrat"
                                            class="form-control @error('contrat') border-warning @enderror w-100"
                                            id="contrat" placeholder="Contrat">
                                    </div>
                                    @error('contrat')
                                        <div class="text-warning">
                                            Le champs contrat est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="buddy">Buddy</label>
                                        <input value="{{ json_decode($oneMembre->info)->buddy }}" type="text"
                                            name="buddy" class="form-control @error('buddy') border-warning @enderror w-100"
                                            id="buddy" placeholder="Buddy">
                                    </div>
                                    @error('buddy')
                                        <div class="text-warning">
                                            Le champs buddy est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    {{-- <div class="imgMod">
                                        <img style="width: 150px" src="{{ json_decode($oneMembre->info)->photo_buddy }}"
                                            alt="">
                                    </div> --}}
                                    <div>
                                        <label class="" for="photo_buddy">Photo buddy</label>
                                        <input type="file" name="photo_buddy"
                                            class="form-control @error('photo_buddy') border-warning @enderror w-100"
                                            id="photo_buddy" placeholder="Photo buddy">
                                    </div>
                                    @error('photo_buddy')
                                        <div class="text-warning">
                                            Le champs Photo buddy est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="sautQDN2">Saut quantique danse N2</label>
                                        <input value="{{ json_decode($oneMembre->info)->sautQDN2 }}" type="text"
                                            name="sautQDN2"
                                            class="form-control @error('sautQDN2') border-warning @enderror w-100"
                                            id="sautQDN2" placeholder="Saut quantique danse N2">
                                    </div>
                                    @error('sautQDN2')
                                        <div class="text-warning">
                                            Le champs Saut quantique danse N2 est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="sautQProjetN3">Saut quantique du projet
                                            N3</label>
                                        <input type="text" value="{{ json_decode($oneMembre->info)->sautQProjetN3 }}"
                                            name="sautQProjetN3"
                                            class="form-control @error('sautQProjetN3') border-warning @enderror w-100"
                                            id="sautQProjetN3" placeholder="Saut quantique du projet N3">
                                    </div>
                                    @error('sautQProjetN3')
                                        <div class="text-warning">
                                            Le champs Saut quantique du projet N3 est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="chequeSQ">Cheque saut quantique</label>
                                        <select id="chequeSQ" name="chequeSQ"
                                            class="form-control @error('chequeSQ')
                                        border-warning @enderror">
                                            @if (json_decode($oneMembre->info)->chequeSQ === '1')
                                                <option value="Oui">Oui</option>
                                            @else
                                                <option value="Non">Non</option>
                                            @endif
                                            <option value="1">Oui</option>
                                            <option value="0">Non</option>
                                        </select>
                                    </div>
                                    @error('chequeSQ')
                                        <div class="text-warning">
                                            Le champs Cheque saut quantique est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="leader_inspirant">Leader inspirant</label>
                                        <input value="{{ json_decode($oneMembre->info)->leader_inspirant }}" type="text"
                                            name="leader_inspirant"
                                            class="form-control @error('leader_inspirant') border-warning @enderror w-100"
                                            id="leader_inspirant" placeholder="Leader inspirant">
                                    </div>
                                    @error('leader_inspirant')
                                        <div class="text-warning">
                                            Le champs Leader inspirant est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="chaise_pourcentage">Pourcentage chaise</label>
                                        <input value="{{ json_decode($oneMembre->info)->chaise_pourcentage }}"
                                            type="text" name="chaise_pourcentage"
                                            class="form-control @error('chaise_pourcentage') border-warning @enderror w-100"
                                            id="chaise_pourcentage" placeholder="Pourcentage chaise">
                                    </div>
                                    @error('chaise_pourcentage')
                                        <div class="text-warning">
                                            Le champs Pourcentage chaise est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="sautQuantikReussi">Saut quantique
                                            reussit</label>
                                        <select id="sautQuantikReussi" name="sautQuantikReussi"
                                            class="form-control @error('sautQuantikReussi')
                                        border-warning @enderror">
                                            @if (json_decode($oneMembre->info)->sautQuantikReussi === '1')
                                                <option value="Oui">Oui</option>
                                            @else
                                                <option value="Non">Non</option>
                                            @endif
                                            <option value="1">Oui</option>
                                            <option value="0">Non</option>
                                        </select>
                                    </div>
                                    @error('sautQuantikReussi')
                                        <div class="text-warning">
                                            Le champs Saut quantique reussit est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <div>
                                        <label class="" for="tribut_frere">Frere de tribut</label>
                                        <input value="{{ json_decode($oneMembre->info)->tribut_frere }}" type="text"
                                            name="tribut_frere"
                                            class="form-control @error('tribut_frere') border-warning @enderror w-100"
                                            id="tribut_frere" placeholder="Frere de tribut">
                                    </div>
                                    @error('tribut_frere')
                                        <div class="text-warning">
                                            Le champs Frere de tribut est obligatoire
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-12 col-md-3">
                                    {{-- <img src="{{ json_decode($oneMembre->info)->frere_t_photo }}" style="width: 150px"
                                        alt=""> --}}
                                    <div>
                                        <label class="" for="frere_t_photo">Photo frere de tribut</label>
                                        <input type="file" name="frere_t_photo"
                                            class="form-control @error('frere_t_photo') border-warning @enderror w-100"
                                            id="frere_t_photo" placeholder="Photo frere de tribut">
                                    </div>
                                    @error('frere_t_photo')
                                        <div class="text-warning">
                                            Le champs Photo frere de tribut est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <div>
                                        <label class="" for="animal_totem">Animal totem</label>
                                        {{-- <input value="{{ json_decode($oneMembre->info)->animal_totem }}" type="text"
                                            name="animal_totem"
                                            class="form-control @error('animal_totem') border-warning @enderror w-100"
                                            id="animal_totem" placeholder="Animal totem"> --}}

                                        <select name="animal_totem" id="animal_totem"
                                            class="form-control @error('animal_totem') border-warning @enderror w-100">
                                            <option value="{{ json_decode($oneMembre->info)->animal_totem }}">
                                                {{ json_decode($oneMembre->info)->animal_totem }}</option>
                                            <option value="abeille">Abeille</option>
                                            <option value="aigle">Aigle</option>
                                            <option value="araigne">Araigne</option>
                                            <option value="cerf">Cerf</option>
                                            <option value="Chat">Chat</option>
                                            <option value="cheval">Cheval</option>
                                            <option value="chouette">Chouette</option>
                                            <option value="coccinelle">Coccinelle</option>
                                            <option value="colibri">Colibri</option>
                                            <option value="corbeau">Corbeau</option>
                                            <option value="coyote">Coyote</option>
                                            <option value="girafe">Girafe</option>
                                            <option value="grenouille">Grenouille</option>
                                            <option value="libellule">Libellule</option>
                                            <option value="licorne">Licorne</option>
                                            <option value="lion">Lion</option>
                                            <option value="loup">Loup</option>
                                            <option value="mouton">Mouton</option>
                                            <option value="Ours">Ours</option>
                                            <option value="panda">Panda</option>
                                            <option value="papillon">Papillon</option>
                                            <option value="pieuvre">Pieuvre</option>
                                            <option value="renard">Renard</option>
                                            <option value="serpent">Serpent</option>
                                            <option value="tigre">Tigre</option>
                                            <option value="tortue">Tortue</option>
                                        </select>
                                    </div>
                                    @error('animal_totem')
                                        <div class="text-warning">
                                            Le champs Animal totem est obligatoire
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-3">
                                    <div>
                                        <label class="" for="signe_astro">Signe astro</label>
                                        {{-- <input value="{{ json_decode($oneMembre->info)->signe_astro }}" type="text"
                                            name="signe_astro"
                                            class="form-control @error('signe_astro') border-warning @enderror w-100"
                                            id="signe_astro" placeholder="Signe astro"> --}}

                                        <select name="signe_astro" id="signe_astro"
                                            class="form-control @error('signe_astro') border-warning @enderror w-100">
                                            <option value="{{ json_decode($oneMembre->info)->signe_astro }}">
                                                {{ json_decode($oneMembre->info)->signe_astro }}</option>
                                            <option value="belier">Belier</option>
                                            <option value="taureau">Taureau</option>
                                            <option value="scorpion">Scorpion</option>
                                            <option value="balance">Balance</option>
                                            <option value="vierge">Vierge</option>
                                            <option value="capricorne">Capricorne</option>
                                            <option value="poisson">Poisson</option>
                                            <option value="verseau">Verseau</option>
                                            <option value="Lion">Lion</option>
                                            <option value="Sagitaire">Sagitaire</option>
                                            <option value="cancer">Cancer</option>
                                            <option value="gemeaux">Gemeaux</option>
                                        </select>
                                    </div>
                                    @error('signe_astro')
                                        <div class="text-warning">
                                            Le champs Signe astro danse N2 est obligatoire
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-12 col-md-3">
                                    <div>
                                        <label class="" for="numerologie">Numerologie</label>
                                        <input value="{{ json_decode($oneMembre->info)->numerologie }}" type="number"
                                            name="numerologie"
                                            class="form-control @error('numerologie') border-warning @enderror w-100"
                                            id="numerologie" placeholder="Numerologie">
                                    </div>
                                    @error('numerologie')
                                        <div class="text-warning">
                                            Le champs numerologie est obligatoire
                                        </div>
                                    @enderror
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
