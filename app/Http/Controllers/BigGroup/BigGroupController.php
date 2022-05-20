<?php

namespace App\Http\Controllers\BigGroup;

use App\Http\Controllers\Controller;
use App\Models\GrandGroupe;
use App\Models\Membre;
use App\Models\PetitGroupe;
use Illuminate\Http\Request;

class BigGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $bigGroupes = GrandGroupe::get();
        $allMembres = Membre::get();
        return view('big_groupe.index', [
            'bigGroupes' => $bigGroupes,
            'allMembres'=>$allMembres
        ]);
    }
}