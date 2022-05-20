<?php

namespace App\Http\Controllers\Api\PetitGroupe;

use App\Http\Controllers\Controller;
use App\Models\GrandGroupe;
use App\Models\Membre;
use App\Models\PetitGroupe;
use App\Models\PetitGroupeMembre;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PetitGroupeController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create_pgs', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_pgs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_pgs', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Query all PetitGroup and inject it to the view
        $petit_groupes = PetitGroupe::get();
        $allMembres = Membre::get();
        return $this->success([
            'allMembres'=>$allMembres, 
            'petit_groupes' => $petit_groupes
        ], 'All petitGroupe');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Schema validation for request
        $rules = [
            'capitaine' => 'required|integer',
            'grand_groupe_id' => 'required|integer',
            'photo' => 'required|image|max:25000' // <-- 25mo max upload
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        // Upload the photo to the cloud & get his URL
        $path = Storage::disk('do_spaces')->putFile('/', $request->file('photo'), 'public');
        $url = Storage::disk('do_spaces')->url($path);

        // Try to store all information from body
        try {
            $new_petit_groupe = PetitGroupe::create([
                'capitaine' => $request->capitaine,
                'grand_groupe_id' => $request->grand_groupe_id,
                'photo' => $url
            ]);

            return $this->success($new_petit_groupe, 'New petitGroupe created successfully');
        } catch (QueryException $exception) {
            // catch exception
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Email is already used, please try another', 400);
            }
            return $this->error('An error occured, Please try again', 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $petit_groupe = PetitGroupe::find($id);
        $petit_groupe_membres = PetitGroupeMembre::where('petit_groupe_id', $id)->get();
        $membres = Membre::get();

        return $this->succes([
            'petit_groupe' => $petit_groupe,
            'petit_groupe_membres' => $petit_groupe_membres,
            'membres' => $membres
        ], 'showing petitGroupe');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PetitGroupe $petit_groupe)
    {
        // Validation for request
        $regle = [
            'capitaine' => 'required|integer',
            'grand_groupe_id' => 'required|integer',
            'photo' => 'image|max:25000' // <-- 25mo max upload
        ];
        $validator = Validator::make($request, $regle);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        // get the uploaded photo
        $photo = $request->file('photo');

        // check if a photo was uploaded
        if (isset($photo)) {
            // Upload the photo to the cloud and get his URL
            $path = Storage::disk('do_spaces')->putFile('/', $photo, 'public');
            $url = Storage::disk('do_spaces')->url($path);

            // Update petit_groupe with freshly generated URL
            try {
                $petit_groupe->capitaine = $request->capitaine;
                $petit_groupe->grand_groupe_id = $request->grand_groupe_id;
                $petit_groupe->photo = $url;
                $petit_groupe->save();

                return $this->success($petit_groupe, 'Petit groupe updated successfully');
            } catch (QueryException $exception) {
                // Catch exception
                // Send flash message if error
                if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                    return $this->error('Username of Email is not available', 400);
                }
                return $this->error('An error occured, please try again', 400);
            }
        } else {

            // If no photo was uploaded, don't modify the photo inside DB
            try {
                $petit_groupe->capitaine = $request->capitaine;
                $petit_groupe->grand_groupe_id = $request->grand_groupe_id;
                $petit_groupe->save();

                return $this->success($petit_groupe, 'Petit groupe updated successfully');
            } catch (QueryException $exception) {
                // Catch exception
                // Send flash message if error
                if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                    return $this->error('Username of Email is not available', 400);
                }
                return $this->error('An error occured, please try again', 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PetitGroupe $petit_groupe)
    {
        $petit_groupe->delete();
        return $this->success($petit_groupe, 'PetiGroupe deleted successfully');
    }
}