<?php

namespace App\Http\Controllers\PetitGroupe;

use App\Http\Controllers\Controller;
use App\Models\GrandGroupe;
use App\Models\Membre;
use App\Models\PetitGroupe;
use App\Models\PetitGroupeMembre;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetitGroupeController extends Controller
{

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
        return view('petit_groupe.index', ['allMembres'=>$allMembres, 'petit_groupes' => $petit_groupes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Query all membre & inject it to the view to make the field membre_id select
        $grand_groupes = GrandGroupe::get();
        $allMembres = Membre::get();
        return view('petit_groupe.create', [
            'grand_groupes' => $grand_groupes,
            'allMembres'=>$allMembres
        ]);
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
        $this->validate($request, $rules);

        // Upload the photo to the cloud & get his URL
        $path = Storage::disk('do_spaces')->putFile('/', $request->file('photo'), 'public');
        $url = Storage::disk('do_spaces')->url($path);

        // Try to store all information from body
        try {
            PetitGroupe::create([
                'capitaine' => $request->capitaine,
                'grand_groupe_id' => $request->grand_groupe_id,
                'photo' => $url
            ]);

            return redirect()->route('admin.all_petit_groupes')->with("message", "Un petit groupe a ete créée");
        } catch (QueryException $exception) {
            // catch exception
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Adresse mail deja utilise, essayer a nouveau");
            }
            return back()->with("error", "Une erreur s'est produit, essayer a nouveau");
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

        return view('petit_groupe.show', [
            'petit_groupe' => $petit_groupe,
            'petit_groupe_membres' => $petit_groupe_membres,
            'membres' => $membres
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // query all membres and inject it to the view to make it available for select field
        // query petit_groupe and inject it inside view
        $grand_groupes = GrandGroupe::get();
        $petit_groupe = PetitGroupe::find($id);
        $allMembres = Membre::get();
        return view('petit_groupe.edit', ['petit_groupe' => $petit_groupe,'allMembres'=>$allMembres, 'grand_groupes' => $grand_groupes]);
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
        $this->validate($request, $regle);

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

                return redirect()->route('admin.all_petit_groupes')->with("message", "Un petit groupe a été modifiée avec succès");
            } catch (QueryException $exception) {
                // Catch exception
                // Send flash message if error
                if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                    return back()->with("error", "Nom d'utilisateur ou adresse email non disponible, essayer une autre S.V.P !");
                }
                return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
            }
        } else {

            // If no photo was uploaded, don't modify the photo inside DB
            try {
                $petit_groupe->capitaine = $request->capitaine;
                $petit_groupe->grand_groupe_id = $request->grand_groupe_id;
                $petit_groupe->save();

                return redirect()->route('admin.all_petit_groupes')->with("message", "Un petit groupe a été modifiée avec succès");
            } catch (QueryException $exception) {
                // Send flash message if error
                if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                    return back()->with("error", "Nom d'utilisateur ou adresse email non disponible, essayer une autre S.V.P !");
                }
                return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
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

        return back()->with("message", "Un petit groupe a été supprimée avec succès");
    }
}