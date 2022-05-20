<?php

namespace App\Http\Controllers\Api\Membre;

use App\Http\Controllers\Controller;
use App\Models\EvenementMembre;
use App\Models\Lien;
use App\Models\Membre;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MemberManipController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create_membres', ['only' => ['index', 'store']]);
        $this->middleware('permission:edit_membres', ['only' => ['edit_membre', 'update_membre']]);
        $this->middleware('permission:delete_membres', ['only' => ['destroy_membre']]);
    }

    /**
     * Create membre
     */
    public function store(Request $request)
    {
        $rules = [
            'status' => 'required',
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'genre' => 'required',
            'date_naissance' => 'required',
            'nationalite' => 'required|string',
            'telephone' => 'required',
            'civil_state' => 'required|string',
            'metier' => 'required|string',
            'talents' => 'required|string',
            'ange' => 'nullable|string',
            'origin_invi' => 'required|string',
            'contact_perso' => 'required|string',
            'sautQDanse' => 'nullable|string',
            'musicSautQ' => 'nullable|string',
            'musicVol' => 'nullable|string',
            'contrat' => 'nullable|string',
            'buddy' => 'nullable|string',
            'photo_buddy' => 'nullable|image',
            'sautQDN2' => 'nullable|string',
            'sautQProjetN3' => 'nullable|string',
            'chequeSQ' => 'nullable|boolean',
            'leader_inspirant' => 'nullable|string',
            'chaise_pourcentage' => 'nullable|numeric',
            'sautQuantikReussi' => 'nullable|boolean',
            'tribut_frere' => 'nullable|string',
            'frere_t_photo' => 'nullable|image',
            'animal_totem' => 'required|string',
            'signe_astro' => 'required|string',
            'numerologie' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()) {
            return $this->error('Data is invalid',  400);
        }

        $photoBoddy = $request->file('photo_buddy');
        $photo_brother = $request->file('frere_t_photo');

        $pathPhotoBuddy = isset($photoBoddy) ? Storage::disk('do_spaces')->putFile('/', $photoBoddy, 'public') : "";
        $pathPhotoFrereT = isset($photo_brother) ? Storage::disk('do_spaces')->putFile('/', $photo_brother, 'public') : "";

        $urlPhotoBuddy = $pathPhotoBuddy !== "" ? Storage::disk('do_spaces')->url($pathPhotoBuddy) : "";
        $urlPhotoFrereT = $pathPhotoFrereT !== "" ? Storage::disk('do_spaces')->url($pathPhotoFrereT) : "";
        try {
            $new_member = Membre::create([
                "status" => $request->status,
                "info" => json_encode([
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'genre' => $request->genre,
                    'date_naissance' => $request->date_naissance,
                    'nationalite' => $request->nationalite,
                    'telephone' => $request->telephone,
                    'civil_state' => $request->civil_state,
                    'metier' => $request->metier,
                    'talents' => $request->talents,
                    'ange' => $request->ange,
                    'origin_invi' => $request->origin_invi,
                    'contact_perso' => $request->contact_perso,
                    'sautQDanse' => $request->sautQDanse,
                    'musicSautQ' => $request->musicSautQ,
                    'musicVol' => $request->musicVol,
                    'contrat' => $request->contrat,
                    'buddy' => $request->buddy,
                    'photo_buddy' => $urlPhotoBuddy,
                    'sautQDN2' => $request->sautQDN2,
                    'sautQProjetN3' => $request->sautQProjetN3,
                    'chequeSQ' => $request->chequeSQ,
                    'leader_inspirant' => $request->leader_inspirant,
                    'chaise_pourcentage' => $request->chaise_pourcentage,
                    'sautQuantikReussi' => $request->sautQuantikReussi,
                    'tribut_frere' => $request->tribut_frere,
                    'frere_t_photo' => $urlPhotoFrereT,
                    'animal_totem' => $request->animal_totem,
                    'signe_astro' => $request->signe_astro,
                    'numerologie' => $request->numerologie
                ])
            ]);
            return $this->success($new_member, 'New member added successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('This mail is already used, please try another', 400);
            }
            return $this->error('An error occured, try again', 400);
        }
    }

    /**
     * Update membre
     */

    public function update_membre(Request $request, Membre $membre){
        $photoBoddy = $request->file('photo_buddy');
        $photo_brother = $request->file('frere_t_photo');

        $pathPhotoBuddy = isset($photoBoddy) ? Storage::disk('do_spaces')->putFile('/', $photoBoddy, 'public') : "";
        $pathPhotoFrereT = isset($photo_brother) ? Storage::disk('do_spaces')->putFile('/', $photo_brother, 'public') : "";

        $urlPhotoBuddy = $pathPhotoBuddy !== "" ? Storage::disk('do_spaces')->url($pathPhotoBuddy) : "";
        $urlPhotoFrereT = $pathPhotoFrereT !== "" ? Storage::disk('do_spaces')->url($pathPhotoFrereT) : "";


        try {
            $membre->status = $request->status;
            $membre->info = json_encode([
                'nom'=>$request->nom,
                'prenom'=>$request->prenom,
                'email'=>$request->email,
                'genre'=>$request->genre,
                'date_naissance'=>$request->date_naissance,
                'nationalite'=>$request->nationalite,
                'telephone'=>$request->telephone,
                'civil_state'=> $request->civil_state,
                'metier'=>$request->metier,
                'talents'=>$request->talents,
                'origin_invi'=>$request->origin_invi,
                'contact_perso' => $request->contact_perso,
                'sautQDanse' => $request->sautQDanse,
                'musicSautQ' => $request->musicSautQ,
                'musicVol' => $request->musicVol,
                'contrat' => $request->contrat,
                'buddy' => $request->buddy,
                'ange'=>$request->ange,
                'photo_buddy'=> $urlPhotoBuddy !== "" ? $urlPhotoBuddy : json_decode($membre->info)->photo_buddy,
                'sautQDN2'=>$request->sautQDN2,
                'sautQProjetN3'=>$request->sautQProjetN3,
                'chequeSQ'=>$request->chequeSQ,
                'leader_inspirant'=>$request->leader_inspirant,
                'chaise_pourcentage'=>$request->chaise_pourcentage,
                'sautQuantikReussi'=> $request->sautQuantikReussi,
                'tribut_frere' => $request->tribut_frere,
                'frere_t_photo'=> $urlPhotoFrereT !== "" ? $urlPhotoFrereT : json_decode($membre->info)->frere_t_photo,
                'animal_totem'=> $request->animal_totem,
                'signe_astro'=>$request->signe_astro,
                'numerologie'=> $request->numerologie
            ]);
            $membre->save();
            return $this->success($membre, 'Member updated successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('This email is already used, please try another', 400);
            }
            return $this->error('An error occured, try again', 400);
        }
    }

    /**
     * Delete membre
     */

    public function destroy_membre(Membre $membre)
    {
        $membre->delete();
        return $this->success($membre, 'Member deleted successfully');
    }

    /**
     * Afficher un membre detail
     */

    public function show_membre($id)
    {
        $membre = Membre::find($id);
        $participants = EvenementMembre::where('membre_id', $id)->get();
        $date_naissance = json_decode($membre->info)->date_naissance;

        $now = Carbon::now();

        $lien = Lien::where('membre_id', $id)->get();
        $links = Lien::where('prospect_id', $id)->get();
        // Calcule age du membre
        $diff = $now->diffInYears($date_naissance);
        return $this->success([
            "membre" => $membre,
            "participants"=>$participants,
            "diff"=>$diff,
            "lien"=>$lien,
            'links'=>$links
        ], 'Member details');
        
    }
}