<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\Membre;
use App\Models\StaffList;
use App\Models\StaffMembre;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Redirect;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create_staffs', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_staffs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_staffs', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = StaffList::get();
        return view('staff.index', [
            "staffs" => $staffs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $evenements = Evenement::get();
        return view('staff.create', [
            "evenements" => $evenements
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
            'nom' => 'required|string|max:255',
            'mantra' => 'required|string',
            'type' => 'required|string',
            'logo' => 'required|image|max:25000', // <-- 25mo max upload
            'photo' => 'required|image|max:25000', // <-- 25mo max upload
            'event_gg_id' => 'nullable|integer',
            'event_mem_id' => 'nullable|integer',
            'event_abandon_id' => 'nullable|integer',
            'ev_abd_membre_id' => 'nullable|integer'
        ];
        $this->validate($request, $rules);

        // Upload photo to the cloud & get his URL
        $path_photo = Storage::disk('do_spaces')->putFile('/', $request->file('photo'), 'public');
        $url_photo = Storage::disk('do_spaces')->url($path_photo);

        // Upload photo to the cloud & get his URL
        $path_logo = Storage::disk('do_spaces')->putFile('/', $request->file('logo'), 'public');
        $url_logo = Storage::disk('do_spaces')->url($path_logo);

        // Try to store all information from request body
        try {
            StaffList::create([
                'nom' => $request->nom,
                'mantra' => $request->mantra,
                'type' => $request->type,
                'photo' => $url_photo,
                'logo' => $url_logo,
                'event_mem_id' => $request->event_mem_id,
                'event_gg_id' => $request->event_gg_id,
                'event_abandon_id' => $request->event_abandon_id,
                'ev_abd_membre_id' => $request->ev_abd_membre_id
            ]);

            // dd();

            // redirect to list of staff if success
            return redirect()->back()->with('message', 'Un staff a ete créée');
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Adresse email non disponible, essayer une autre S.V.P !");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
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
        $staff = StaffList::find($id);
        $staff_membres = StaffMembre::where('staff_list_id', $id)->get();
        $membres = Membre::get();
        return view('staff.show', [
            "staff" => $staff,
            "staff_membres" => $staff_membres,
            "membres" => $membres
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
        $evenements = Evenement::get();
        $staff = StaffList::find($id);
        return view('staff.edit', [
            "staff" => $staff,
            "evenements" => $evenements
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffList $staff)
    {
        // Schema validation for request
        $regles = [
            'nom' => 'required|string|max:255',
            'mantra' => 'required|string',
            'type' => 'required|string',
            'logo' => 'image|max:25000', // <-- 25mo max upload
            'photo' => 'image|max:25000', // <-- 25mo max upload
            'event_gg_id' => 'nullable|integer',
            'event_mem_id' => 'nullable|integer',
            'event_abandon_id' => 'nullable|integer',
            'ev_abd_membre_id' => 'nullable|integer'
        ];
        $this->validate($request, $regles);

        $logo = $request->file("logo");
        $photo = $request->file("photo");

        // upload logo to the cloud
        $path_photo = isset($photo) ? Storage::disk('do_spaces')->putFile('/', $photo, 'public') : "";
        $url_photo = $path_photo !== "" ? Storage::disk('do_spaces')->url($path_photo) : "";

        // Upload photo to the cloud & get his URL
        $path_logo = isset($logo) ? Storage::disk('do_spaces')->putFile('/', $logo, 'public') : "";
        $url_logo = $path_logo !== "" ? Storage::disk('do_spaces')->url($path_logo) : "";

        // Update staff with freshly generated URL
        try {
            $staff->nom = $request->nom;
            $staff->mantra = $request->mantra;
            $staff->type = $request->type;
            $staff->logo = $url_logo !== "" ? $url_logo : $staff->logo;
            $staff->photo = $url_photo !== "" ? $url_photo : $staff->photo;
            $staff->event_mem_id = $request->event_mem_id;
            $staff->event_gg_id = $request->event_gg_id;
            $staff->event_abandon_id = $request->event_abandon_id;
            $staff->ev_abd_membre_id = $request->ev_abd_membre_id;

            $staff->save();

            return redirect()->route('admin.all_staffs')->with("message", "Un staff a été modifiée avec succès");
        } catch (QueryException $exception) {
            // Catch exception
            // Send flash message if error
            // dd($exception->getMessage());
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Nom d'utilisateur ou adresse email non disponible, essayer une autre S.V.P !");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffList $staff)
    {
        $staff->delete();

        return back()->with("message", "Un petit groupe a été supprimée avec succès");
    }
}