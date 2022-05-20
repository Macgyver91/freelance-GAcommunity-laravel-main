<?php

namespace App\Http\Controllers\Api\EventMembre;

use App\Http\Controllers\Controller;
use App\Models\EvenementMembre;
use App\Models\StaffList;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EvenementMembreController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:participant_event', ['only' => ['store_participant', 'destroy_participant']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_participant(Request $request)
    {
        // Schema validation for request
        $rules = [
            'states' => 'required',
            'evenement_id' => 'required|integer'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        // request->states contains array of membres because of multi-select
        $participants = $request->states;
        // Loop request->states to create EvenementMembre rows
        foreach ($participants as $participant) {
            EvenementMembre::create([
                'membre_id' => $participant,
                'evenement_id' => $request->evenement_id
            ]);
        }

        return $this->success($participants, 'Participant(s) added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_participant(Request $request, EvenementMembre $event_membre)
    {
        // Schema validation for request
        $regles = [
            'membre_id' => 'required|integer',
            'evenement_id' => 'required|integer'
        ];
        $validator = Validator::make($request->all(), $regles);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        }

        // Try to store all information from request body
        try {
            $event_membre->membre_id = $request->membre_id;
            $event_membre->evenement_id = $request->evenement_id;

            // redirect to list of staff if success
            return $this->success($event_membre, 'Participant updated successfully');
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Email already used, please try with another', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_participant(EvenementMembre $participant)
    {
        $participant->delete();
        return $this->success($participant, 'Participant deleted successfully');
    }
}