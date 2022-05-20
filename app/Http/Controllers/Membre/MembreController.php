<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use Illuminate\Http\Request;

class MembreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $membres = Membre::latest()->paginate(200);
        return view('membre.index', [
            'membres' => $membres
        ]);
    }
}
