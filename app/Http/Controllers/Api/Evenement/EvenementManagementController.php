<?php

namespace App\Http\Controllers\Api\Evenement;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\StaffList;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvenementManagementController extends Controller
{
    use ApiResponser;

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
        $validator = Validator::make($request->all(), $rule);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        } 

        // Try to attach a grand groupe to evenement
        try {
            $event->grand_groupe_id = $request->grand_groupe_id;
            $event->save();

            return $this->success($event, 'Group added to event successfully');
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            return $this->error('An error occured, please try again', 400);
        }
    }

    public function remove_grand_groupe(Request $request, Evenement $event)
    {

        // Try to attach a grand groupe to evenement
        try {
            $event->grand_groupe_id = null;
            $event->save();

            $this->success($event, 'A big group dissociated from event successfully');
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            return $this->error('An error occured, please try again', 400);
        }
    }

    public function store_staff_event(Request $request, Evenement $event)
    {
        $rules = [
            'staff_id' => 'required|integer'
        ];
        $validator = Validator::make($request, $rules);
        $staff = StaffList::find($request->staff_id);

        try {
            $staff->evenement_id = $event->id;
            $staff->save();

            return $this->success($staff, 'Staff added to event successfully');
        } catch (QueryException $exception) {
            return $this->error('An error occured, please try again', 400);
        }
    }

    public function remove_staff_event(Request $request, Evenement $event)
    {
        $rules = [
            'staff_id' => 'required|integer'
        ];
        $validator = Validator::make($request, $rules);
        
        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        $staff = StaffList::find($request->staff_id);

        try {
            $staff->evenement_id = null;
            $staff->save();

            return $this->success($staff, 'Staff dissociated from event successfully');
        } catch (QueryException $exception) {
            return $this->error('An error occured, please try again', 400);
        }
    }
}