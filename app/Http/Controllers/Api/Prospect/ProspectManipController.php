<?php

namespace App\Http\Controllers\Api\Prospect;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use App\Traits\ApiResponser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProspectManipController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Request $request)
    {
        $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'type' => 'required',
            'tel' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        }

        try {
            $new_prospect = Prospect::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'type' => $request->type,
                'tel' => $request->tel,
            ]);
            return $this->success($new_prospect ,'New prospect created successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Email already used, please try with another one', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    public function show_prospect($id)
    {
        $prospect = Prospect::find($id);
        return $this->success($prospect, 'Result of findOne prospect');
    }

    public function update_prospect(Request $request, Prospect $prospect)
    {
        $regles = [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email',
            'type' => 'required',
            'tel' => 'required',
        ];

        $validator = Validator::make($request->all(), $regles);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        }

        try {
            $prospect->nom = $request->nom;
            $prospect->prenom = $request->prenom;
            $prospect->email = $request->email;
            $prospect->tel = $request->tel;
            $prospect->type = $request->type;
            $prospect->save();
            return $this->success($prospect ,'Prospect updated successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('Email already used, please try with another one', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    public function destroy_prospect(Prospect $prospect)
    {
        $prospect->delete();
        return $this->success($prospect, 'Prospect deleted successfully');
    }
}