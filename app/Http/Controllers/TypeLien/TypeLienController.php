<?php

namespace App\Http\Controllers\TypeLien;

use App\Http\Controllers\Controller;
use App\Models\TypeLien;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TypeLienController extends Controller
{
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
        return view('type_lien.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = [
            'name' => 'required|string'
        ];
        $this->validate($request, $rule);

        try {
            TypeLien::create([
                'name' => $request->name
            ]);
            return back()->with("message", "Une type de lien a été crée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Erreur de creation de type de lien");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
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
        $type_lien = TypeLien::find($id);
        return view('type_lien.update', [
            'type_lien' => $type_lien
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeLien $type_lien)
    {
        $rules = [
            'name' => 'required|string'
        ];
        $this->validate($request, $rules);

        try {
            $type_lien->name = $request->name;
            $type_lien->save();

            return back()->with("message", "Un type lien a été modifiée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Erreur de modification");
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
    public function destroy(TypeLien $type_lien)
    {
        $type_lien->delete();
        return back()->with("message", `Un type lien a été supprimée avec succès!`);
    }
}