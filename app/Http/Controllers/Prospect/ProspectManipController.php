<?php

namespace App\Http\Controllers\Prospect;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProspectManipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('prospect.addProspect');
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
        $this->validate($request, $rules);

        try {
            Prospect::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'type' => $request->type,
                'tel' => $request->tel,
            ]);
            return redirect()->route('admin.store_prospect')->with("message", "Une prospect a été crée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Cette adresse mail déjà utilisé, essayer une autre S.V.P !");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    public function edit_prospect($id)
    {
        $prospect = Prospect::find($id);
        return view('prospect.update_prospect', [
            "prospect" => $prospect
        ]);
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
        $this->validate($request, $regles);

        try {
            $prospect->nom = $request->nom;
            $prospect->prenom = $request->prenom;
            $prospect->email = $request->email;
            $prospect->tel = $request->tel;
            $prospect->type = $request->type;
            $prospect->save();
            return redirect()->route('admin.prospect')->with("message", "Une prospect a été modifiée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Cette adresse mail déjà utilisé, essayer une autre S.V.P !");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    public function destroy_prospect(Prospect $prospect)
    {
        $prospect->delete();
        return back()->with("message", `Prospect supprimée avec succéss!`);
    }
}