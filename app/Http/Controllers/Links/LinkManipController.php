<?php

namespace App\Http\Controllers\Links;

use App\Http\Controllers\Controller;
use App\Models\Lien;
use App\Models\Membre;
use App\Models\Prospect;
use App\Models\TypeLien;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;

class LinkManipController extends Controller
{
    /**
     * Gestion de droit
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Fetch all membres et prospects to page creation lient
     */
    public function index($id)
    {
        $membres = Membre::all();
        $prospects = Membre::all();
        $type_liens = TypeLien::all();
        $membreLien =Membre::find($id);

        return view('links.create_link', [
            'membres' => $membres,
            'prospects' => $prospects,
            'type_liens' => $type_liens,
            'membreLien'=>$membreLien
        ]);
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
        $this->validate($request, $rules);

        try {
            Lien::create([
                'type_lien_id' => $request->type_lien_id,
                'membre_id' => $request->membre_id,
                'prospect_id' => $request->prospect_id
            ]);
            return redirect()->back()->with("message", "Un lien entre 2 individus à été crée");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Erreur de creation de lien");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }
    /**
     * Edit lien
     */
    public function edit_link($id)
    {
        $link = Lien::find($id);
        $membres = Membre::all();
        $prospects = Prospect::all();
        $type_liens = TypeLien::all();

        return view('links.update_link', [
            "link" => $link,
            'membres' => $membres,
            'prospects' => $prospects,
            'type_liens' => $type_liens
        ]);
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
        $this->validate($request, $regles);

        try {
            $link->type_lien_id = $request->type_lien_id;
            $link->membre_id = $request->membre_id;
            $link->prospect_id = $request->prospect_id;
            $link->save();
            return redirect()->route('admin.all_events')->with("message", "Un lien a été modifiée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Erreur de modification");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Delete links
     */

    public function delete_link(Lien $lien)
    {
        $lien->delete();
        return back()->with("message", `Lien entre le membre supprimée avec succès !`);
    }
}