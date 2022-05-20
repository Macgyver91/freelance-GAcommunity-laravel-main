<?php

namespace App\Http\Controllers\Api\Abandon;

use App\Http\Controllers\Controller;
use App\Models\Abandon;
use App\Models\Evenement;
use App\Models\EvenementMembre;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;

class AbandonController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:create_abandons', ['only' => ['store_abandon_event']]);
    }

    public function store_abandon_event(HttpRequest $request, Evenement $event)
    {

        // Schema validation for request
        $validator = Validator::make($request->all(), [
            'motif' => "required|string",
            'nb_rate' => 'required',
            'membre_id' => 'required'
        ]);

        if($validator->fails()) {
            return $this->error('Invalid data', 400);
        }

        // Try to store all information from request body
        try {
            // delete the participant inside event when abandon
            $participant = EvenementMembre::where("membre_id", $request->membre_id)->first();

            $participant->delete();

            $abandon = Abandon::create([
                'motif' => $request->motif,
                'nb_rate' => $request->nb_rate,
                'membre_id' => $request->membre_id,
                'evenement_id' => $event->id
            ]);

            return $this->success($abandon, 'A participant abandonned successfully');
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            return $this->error('An error occured, please try again', 400);
        }
    }
}