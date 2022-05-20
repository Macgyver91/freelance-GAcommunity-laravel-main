<?php

namespace App\Http\Controllers\Evenement;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\StaffList;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EvenementManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:event_management', ['only' => ['add_grand_groupe', 'remove_grand_groupe', 'store_staff_event', 'remove_staff_event']]);
    }

    public function add_grand_groupe(Request $request, Evenement $event)
    {
        // Schema validation for request
        $rule = [
            'grand_groupe_id' => 'required|integer'
        ];
        $this->validate($request, $rule);

        // Try to attach a grand groupe to evenement
        try {

            $event->grand_groupe_id = $request->grand_groupe_id;
            $event->save();

            // redirect to list of staff if success
            return back()->with("message", "Un grand groupe a été ajouté a un évènement");
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            return back()->with("error", "Une évènement a été supprimée avec succès");
        }
    }

    public function remove_grand_groupe(Request $request, Evenement $event)
    {

        // Try to attach a grand groupe to evenement
        try {
            $event->grand_groupe_id = null;
            $event->save();

            // redirect to list of staff if success
            return back()->with("message", "Un grand groupe a été supprimé a un évènement");
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    public function store_staff_event(Request $request, Evenement $event)
    {
        $rules = [
            'staff_id' => 'required|integer'
        ];
        $this->validate($request, $rules);

        $staff = StaffList::find($request->staff_id);

        try {
            $staff->evenement_id = $event->id;
            $staff->save();

            return back()->with("message", "Staff a ete ajoutee");
        } catch (QueryException $exception) {
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    public function remove_staff_event(Request $request, Evenement $event)
    {
        $rules = [
            'staff_id' => 'required|integer'
        ];
        $this->validate($request, $rules);

        $staff = StaffList::find($request->staff_id);

        try {
            $staff->evenement_id = null;
            $staff->save();

            return back()->with("message", "Un staff a été créée avec succès");
        } catch (QueryException $exception) {
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }
}