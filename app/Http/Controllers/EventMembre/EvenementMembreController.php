<?php

namespace App\Http\Controllers\EventMembre;

use App\Http\Controllers\Controller;
use App\Models\EvenementMembre;
use App\Models\StaffList;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class EvenementMembreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:participant_event', ['only' => ['store_participant', 'destroy_participant']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $this->validate($request, $rules);

        // request->states contains array of membres because of multi-select
        $participants = $request->states;
        // Loop request->states to create EvenementMembre rows
        foreach ($participants as $participant) {
            EvenementMembre::create([
                'membre_id' => $participant,
                'evenement_id' => $request->evenement_id
            ]);
        }

        return back()->with("message", "Participant(s) ajouté avec succès ");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $this->validate($request, $regles);

        // Try to store all information from request body
        try {
            $event_membre->membre_id = $request->membre_id;
            $event_membre->evenement_id = $request->evenement_id;

            // redirect to list of staff if success
            return back()->with("message", "Un participant a été modifié avec succès");
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Adresse mail déjà utilise, essayer une autre S.V.P !");
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
    public function destroy_participant(EvenementMembre $participant)
    {
        $participant->delete();

        return back()->with("message", "Un participant a été supprimé avec succès");
    }
}