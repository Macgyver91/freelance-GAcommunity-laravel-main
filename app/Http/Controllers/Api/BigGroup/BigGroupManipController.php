<?php

namespace App\Http\Controllers\Api\BigGroup;

use App\Http\Controllers\Controller;
use App\Models\GrandGroupe;
use App\Models\Membre;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BigGroupManipController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create_ggs', ['only' => ['create_big_groupe', 'index']]);
        $this->middleware('permission:edit_ggs', ['only' => ['getBigGroup', 'update_grand_group']]);
        $this->middleware('permission:delete_ggs', ['only' => ['delete_grand_g']]);
    }

    /**
     * Create grand groupe
     */
    public function create_big_groupe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'nom' => 'required',
            'mantra' => 'required',
            'declaration' => 'required',
            'photo' => 'required|image|max:25000',
            'logo' => 'required|image',
            'musique_choree' => 'required|file|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'video_choree' => 'required|file|mimes:mp4,avi,flv,gif,mpeg|max:200000',
            'photo_drapeau' => 'required|image|max:25000',
            'capitaine' => 'required',
            'co_capitaine' => 'required',
            'resp_com' => 'required',
            'resp_heritage' => 'required',
            'resp_anges' => 'required',
            'resp_bateau' => 'required'
        ]);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        $pathPhoto = Storage::disk('do_spaces')->putFile('/', $request->file('photo'), 'public');
        $pathLogo = Storage::disk('do_spaces')->putFile('/', $request->file('logo'), 'public');
        $pathMusic = Storage::disk('do_spaces')->putFile('/', $request->file('musique_choree'), 'public');
        $pathVideo = Storage::disk('do_spaces')->putFile('/', $request->file('video_choree'), 'public');
        $pathDrapeau = Storage::disk('do_spaces')->putFile('/', $request->file('photo_drapeau'), 'public');

        $urlPhoto = Storage::disk('do_spaces')->url($pathPhoto);
        $urlLogo = Storage::disk('do_spaces')->url($pathLogo);
        $urlMusic = Storage::disk('do_spaces')->url($pathMusic);
        $urlVideo = Storage::disk('do_spaces')->url($pathVideo);
        $urlDrapeau = Storage::disk('do_spaces')->url($pathDrapeau);

        try {
            $new_big_group = GrandGroupe::create([
                'type' => $request->type,
                'nom' => $request->nom,
                'mantra' => $request->mantra,
                'declaration' => $request->declaration,
                'photo' => $urlPhoto,
                'logo' => $urlLogo,
                'musique_choree' => $urlMusic,
                'video_choree' => $urlVideo,
                'photo_drapeau' => $urlDrapeau,
                'capitaine' => $request->capitaine,
                'co_capitaine' => $request->co_capitaine,
                'resp_com' => $request->resp_com,
                'resp_heritage' => $request->resp_heritage,
                'resp_anges' => $request->resp_anges,
                'resp_bateau' => $request->resp_bateau
            ]);
            return $this->success($new_big_group ,'New big_group created successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('An error occured during bigGroup creation', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }
    /**
     * Get one big group
     */

    public function show_big_group($id)
    {
        $bgroup = GrandGroupe::find($id);
        return $this->success($bgroup, 'get one bigGroup');
    }

    /**
     * Update grand group
     */

    public function update_grand_group(Request $request, GrandGroupe $g_group)
    {
        $rules = [
            'type' => 'required',
            'nom' => 'required',
            'mantra' => 'required',
            'declaration' => 'required',
            'photo' => 'image|max:25000',
            'logo' => 'image|max:25000',
            'musique_choree' => 'file|mimes:audio/mpeg,mpga,mp3,wav,aac|max:2000000',
            'video_choree' => 'file|mimes:mp4,avi,flv,gif,mpeg|max:2000000',
            'photo_drapeau' => 'image|max:25000',
            'capitaine' => 'required',
            'co_capitaine' => 'required',
            'resp_com' => 'required',
            'resp_heritage' => 'required',
            'resp_anges' => 'required',
            'resp_bateau' => 'required'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails) {
            $this->return('Invalid Data', 400);
        } 

        $photo = $request->file('photo');
        $logo = $request->file('logo');
        $music = $request->file('musique_choree');
        $video = $request->file('video_choree');
        $photo_drapeau = $request->file('photo_drapeau');

        $pathPhoto = isset($photo) ? Storage::disk('do_spaces')->putFile('/', $photo, 'public') : "";
        $pathLogo = isset($logo) ? Storage::disk('do_spaces')->putFile('/', $logo, 'public') : "";
        $pathMusic = isset($music) ? Storage::disk('do_spaces')->putFile('/', $music, 'public') : "";
        $pathVideo = isset($video) ? Storage::disk('do_spaces')->putFile('/', $video, 'public') : "";
        $pathDrapeau = isset($photo_drapeau) ? Storage::disk('do_spaces')->putFile('/', $photo_drapeau, 'public') : "";

        $urlPhoto = $pathPhoto !== "" ? Storage::disk('do_spaces')->url($pathPhoto) : "";
        $urlLogo = $pathLogo !== "" ? Storage::disk('do_spaces')->url($pathLogo) : "";
        $urlMusic = $pathMusic !== "" ? Storage::disk('do_spaces')->url($pathMusic) : "";
        $urlVideo = $pathVideo !== "" ? Storage::disk('do_spaces')->url($pathVideo) : "";
        $urlDrapeau = $pathDrapeau !== "" ? Storage::disk('do_spaces')->url($pathDrapeau) : "";


        try {
            $g_group->type = $request->type;
            $g_group->nom = $request->nom;
            $g_group->mantra = $request->mantra;
            $g_group->declaration = $request->declaration;
            $g_group->photo = $urlPhoto !== "" ? $urlPhoto : $g_group->photo;
            $g_group->logo = $urlLogo !== "" ? $urlLogo : $g_group->logo;
            $g_group->musique_choree = $urlMusic !== "" ? $urlMusic : $g_group->musique_choree;
            $g_group->video_choree = $urlVideo !== "" ? $urlVideo : $g_group->video_choree;
            $g_group->photo_drapeau = $urlDrapeau !== "" ? $urlDrapeau : $g_group->photo_drapeau;
            $g_group->capitaine = $request->capitaine;
            $g_group->co_capitaine = $request->co_capitaine;
            $g_group->resp_com = $request->resp_com;
            $g_group->resp_heritage = $request->resp_heritage;
            $g_group->resp_anges = $request->resp_anges;
            $g_group->resp_bateau = $request->resp_bateau;
            $g_group->save();

            return $this->succes($g_group, 'BigGroup updated successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Username of Email is not avalaible', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    // Delete grand membre
    public function delete_grand_g(GrandGroupe $g_group)
    {
        $g_group->delete();
        return $this->success($g_group, 'BigGroup deleted successfully');
    }
}