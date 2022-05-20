<?php

namespace App\Http\Controllers\Api\PetitGroupeMembre;

use App\Http\Controllers\Controller;
use App\Models\PetitGroupe;
use App\Models\PetitGroupeMembre;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PetitGroupeMembreController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:membre_petit_groupe', ['only' => ['store_membre_petit_groupe', 'destroy_membre_petit_groupe']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_membre_petit_groupe(Request $request, PetitGroupe $petit_groupe)
    {
        // Schema validation for request
        $rule = [
            'states' => 'required'
        ];
        $this->validate($request, $rule);

        // request->states contains array of membres because of multi-select
        $participants = $request->states;

        // Loop request->states to create EvenementMembre rows
        foreach ($participants as $participant) {
            PetitGroupeMembre::create([
                'membre_id' => $participant,
                'petit_groupe_id' => $petit_groupe->id
            ]);
        }

        return $this->success(null, 'Member added in a petitGroupe');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy_membre_petit_groupe(PetitGroupeMembre $petit_groupe_membre)
    {
        $petit_groupe_membre->delete();
        return $this->success('$petit_goupe_membre', 'An petit_gorupe_membre deleted successfully');
    }
}