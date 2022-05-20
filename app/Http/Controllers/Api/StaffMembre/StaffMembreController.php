<?php

namespace App\Http\Controllers\Api\StaffMembre;

use App\Http\Controllers\Controller;
use App\Models\StaffList;
use App\Models\StaffMembre;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffMembreController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:membre_staff', ['only' => ['store_staff_membre', 'destroy_membre_staff']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_staff_membre(Request $request, StaffList $staffList)
    {
        // dd($staff_list->id, $request->all());
        // Schema validation for request
        $rules = [
            'membre_id' => 'required|integer',
            'commentaire' => 'required|string',
            'taux_de_passage' => 'required|integer',
            'role_du_staff' => 'required|string',
        ];
        $validator = Validator::make($request, $rules);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        $staff_membre = StaffMembre::create([
            'membre_id' => $request->membre_id,
            'staff_list_id' => $staffList->id,
            'commentaire' => $request->commentaire,
            'taux_de_passage' => $request->taux_de_passage,
            'role_du_staff' => $request->role_du_staff,
        ]);

        return $this->success($staff_membre, 'StaffMembre added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_membre_staff(StaffMembre $staff_membre)
    {
        $staff_membre->delete();
        return $this->success($staff_membre, 'Staff deleted successfully');
    }
}