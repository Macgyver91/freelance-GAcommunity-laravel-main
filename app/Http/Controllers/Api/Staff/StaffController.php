<?php

namespace App\Http\Controllers\Api\Staff;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\Membre;
use App\Models\StaffList;
use App\Models\StaffMembre;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Redirect;
use Validator;

class StaffController extends Controller
{
    use ApiResponser;

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
        return $this->success($staffs, 'All staff');
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
        $validator = Validator::make($request, $rules);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        // Upload photo to the cloud & get his URL
        $path_photo = Storage::disk('do_spaces')->putFile('/', $request->file('photo'), 'public');
        $url_photo = Storage::disk('do_spaces')->url($path_photo);

        // Upload photo to the cloud & get his URL
        $path_logo = Storage::disk('do_spaces')->putFile('/', $request->file('logo'), 'public');
        $url_logo = Storage::disk('do_spaces')->url($path_logo);

        // Try to store all information from request body
        try {
            $new_staff =  StaffList::create([
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
            return $this->success($new_staff, 'New staff created successfully');
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Email is not available', 400);
            }
            return $this->error('An error occured, please try again', 400);
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
        return $this->success([
            "staff" => $staff,
            "staff_membres" => $staff_membres,
            "membres" => $membres
        ], 'Find one staff');
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
        $validator = Validator::make($request, $regles);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

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

            return $this->success($staff, 'Staff updated successfully');
        } catch (QueryException $exception) {
            // Catch exception
            // Send flash message if error
            // dd($exception->getMessage());
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Username or email is not available', 400);
            }
            return $this->error('An error occured, please try againn', 400);
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
        return $this->success($staff, 'Staff deleted successfully');
    }
}