<?php

namespace App\Http\Controllers\Abandon;

use App\Http\Controllers\Controller;
use App\Models\Abandon;
use App\Models\Evenement;
use App\Models\EvenementMembre;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request as HttpRequest;

class AbandonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create_abandons', ['only' => ['store_abandon_event']]);
    }

    public function store_abandon_event(HttpRequest $request, Evenement $event)
    {

        // Schema validation for request
        $this->validate($request, [
            'motif' => "required|string",
            'nb_rate' => 'required',
            'membre_id' => 'required'
        ]);

        // Try to store all information from request body
        try {
            // delete the participant inside event when abandon
            $participant = EvenementMembre::where("membre_id", $request->membre_id)->first();

            $participant->delete();

            Abandon::create([
                'motif' => $request->motif,
                'nb_rate' => $request->nb_rate,
                'membre_id' => $request->membre_id,
                'evenement_id' => $event->id
            ]);

            // redirect to list of staff if success
            return back()->with("message", "Un participant a été abandonné");
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }
}