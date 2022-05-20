<?php

namespace App\Http\Controllers\Api\Links;

use App\Http\Controllers\Controller;
use App\Models\Lien;
use App\Models\Membre;
use App\Models\Prospect;
use App\Models\TypeLien;
use App\Traits\ApiResponser;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LinkManipController extends Controller
{
    use ApiResponser;

    /**
     * Gestion de droit
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Creation de lien
     */
    public function create_link(Request $request)
    {
        $rules = [
            'type_lien_id' => 'required',
            'membre_id' => 'required',
            'prospect_id' => 'required'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        }

        try {
            $new_link = Lien::create([
                'type_lien_id' => $request->type_lien_id,
                'membre_id' => $request->membre_id,
                'prospect_id' => $request->prospect_id
            ]);
            return $this->success($new_link ,'New link created successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('AN error occured when trying to create the link', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }
    /**
     * Edit lien
     */
    public function show_link($id)
    {
        $link = Lien::find($id);
        $type_liens = TypeLien::all();

        return $this->success([
            "link" => $link,
            'type_liens' => $type_liens
        ], 'Find one with all type_liens');
    }

    /**
     * Validation edit lien
     */
    public function update_link(Request $request, Lien $link)
    {
        $regles = [
            'type_lien_id' => 'required',
            'membre_id' => 'required',
            'prospect_id' => 'required'
        ];
        
        $validator = Validator::make($request->all(), $regles);

        if($validator->fails()) {
            $this->error('Invalid data', 400);
        }

        try {
            $link->type_lien_id = $request->type_lien_id;
            $link->membre_id = $request->membre_id;
            $link->prospect_id = $request->prospect_id;
            $link->save();
            return $this->success($link ,'Link updated successfully');
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return $this->error('AN error occured when trying to update the link', 400);
            }
            return $this->error('An error occured, please try again', 400);
        }
    }

    /**
     * Delete links
     */

    public function delete_link(Lien $lien)
    {
        $lien->delete();
        return $this->success($lien, 'Link deleted successfully');
    }
}