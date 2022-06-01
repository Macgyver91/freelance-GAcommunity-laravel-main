<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\EvenementMembre;
use App\Models\Invitation;
use App\Models\Lien;
use App\Models\Membre;
use App\Models\PetitGroupe;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MemberManipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create_membres', ['only' => ['index', 'store']]);
        $this->middleware('permission:edit_membres', ['only' => ['edit_membre', 'update_membre']]);
        $this->middleware('permission:delete_membres', ['only' => ['destroy_membre']]);
    }

    public function index()
    {
        $membres = Membre::all();
        return view('membre.addMembre', [
            'membres' => $membres
        ]);
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
        $this->validate($request, $rules);

        $photoBoddy = $request->file('photo_buddy');
        $photo_brother = $request->file('frere_t_photo');

        $pathPhotoBuddy = isset($photoBoddy) ? Storage::disk('do_spaces')->putFile('/', $photoBoddy, 'public') : "";
        $pathPhotoFrereT = isset($photo_brother) ? Storage::disk('do_spaces')->putFile('/', $photo_brother, 'public') : "";

        $urlPhotoBuddy = $pathPhotoBuddy !== "" ? Storage::disk('do_spaces')->url($pathPhotoBuddy) : "";
        $urlPhotoFrereT = $pathPhotoFrereT !== "" ? Storage::disk('do_spaces')->url($pathPhotoFrereT) : "";

        $status = Membre::find($request->ange);

        try {

            Membre::create([
                "status" => $request->status,
                "info"   => json_encode([
                    'nom'                   => $request->nom,
                    'prenom'                => $request->prenom,
                    'email'                 => $request->email,
                    'genre'                 => $request->genre,
                    'date_naissance'        => $request->date_naissance,
                    'nationalite'           => $request->nationalite,
                    'telephone'             => $request->telephone,
                    'civil_state'           => $request->civil_state,
                    'metier'                => $request->metier,
                    'talents'               => $request->talents,
                    'ange'                  => (int)$request->ange,
                    'status_invitation'     => $status ? ($status->status ?? "") : "",
                    'origin_invi'           => $request->origin_invi,
                    'contact_perso'         => $request->contact_perso,
                    'sautQDanse'            => $request->sautQDanse,
                    'musicSautQ'            => $request->musicSautQ,
                    'musicVol'              => $request->musicVol,
                    'contrat'               => $request->contrat,
                    'buddy'                 => $request->buddy,
                    'photo_buddy'           => $urlPhotoBuddy,
                    'sautQDN2'              => $request->sautQDN2,
                    'sautQProjetN3'         => $request->sautQProjetN3,
                    'chequeSQ'              => $request->chequeSQ,
                    'leader_inspirant'      => $request->leader_inspirant,
                    'chaise_pourcentage'    => $request->chaise_pourcentage,
                    'sautQuantikReussi'     => $request->sautQuantikReussi,
                    'tribut_frere'          => $request->tribut_frere,
                    'frere_t_photo'         => $urlPhotoFrereT,
                    'animal_totem'          => $request->animal_totem,
                    'signe_astro'           => $request->signe_astro,
                    'numerologie'           => $request->numerologie
                ])
            ]);
            return redirect()->route('admin.store_membre')->with("message", "Une membre a été crée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Cette adresse mail déjà utilisé, essayer une autre S.V.P !");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Edit membre
     */

    public function edit_membre($id)
    {
        $oneMembre = Membre::find($id);
        // dd($membre);
        $AllMembres = Membre::all();
        $date_naissance = Carbon::parse($oneMembre->date_naissance)->format('Y-m-d');
        return view('membre.update_membre', [
            "oneMembre" => $oneMembre,
            "date_naissance" => $date_naissance,
            "AllMembres" => $AllMembres
        ]);
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
        $status = Membre::find($request->ange);

        try {
            $membre->status = $request->status;
            $membre->info = json_encode([
                'nom'                           =>$request->nom,
                'prenom'                        =>$request->prenom,
                'email'                         =>$request->email,
                'genre'                         =>$request->genre,
                'date_naissance'                =>$request->date_naissance,
                'nationalite'                   =>$request->nationalite,
                'telephone'                     =>$request->telephone,
                'civil_state'                   => $request->civil_state,
                'metier'                        =>$request->metier,
                'talents'                       =>$request->talents,
                'origin_invi'                   =>$request->origin_invi,
                'contact_perso'                 => $request->contact_perso,
                'sautQDanse'                    => $request->sautQDanse,
                'musicSautQ'                    => $request->musicSautQ,
                'musicVol'                      => $request->musicVol,
                'contrat'                       => $request->contrat,
                'buddy'                         => $request->buddy,
                'ange'                          =>(int)$request->ange,
                'status_invitation'             => $status ? ($status->status ?? "") : "",
                'photo_buddy'                   => $urlPhotoBuddy !== "" ? $urlPhotoBuddy : json_decode($membre->info)->photo_buddy,
                'sautQDN2'                      =>$request->sautQDN2,
                'sautQProjetN3'                 =>$request->sautQProjetN3,
                'chequeSQ'                      =>$request->chequeSQ,
                'leader_inspirant'              =>$request->leader_inspirant,
                'chaise_pourcentage'            =>$request->chaise_pourcentage,
                'sautQuantikReussi'             => $request->sautQuantikReussi,
                'tribut_frere'                  => $request->tribut_frere,
                'frere_t_photo'                 => $urlPhotoFrereT !== "" ? $urlPhotoFrereT : json_decode($membre->info)->frere_t_photo,
                'animal_totem'                  => $request->animal_totem,
                'signe_astro'                   =>$request->signe_astro,
                'numerologie'                   => $request->numerologie
            ]);
            $membre->save();
            return redirect()->route('admin.membre')->with("message", "Une membre a été modifiée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Cette adresse mail déjà utilisé, essayer une autre S.V.P !");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Delete membre
     */

    public function destroy_membre(Membre $membre)
    {
        $membre->delete();
        return back()->with("success", `Membre supprimée avec succéss!`);
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
        return view('membre.detail_membre', [
            "membre" => $membre,
            "participants"=>$participants,
            "diff"=>$diff,
            "lien"=>$lien,
            'links'=>$links
        ]);

    }
}
