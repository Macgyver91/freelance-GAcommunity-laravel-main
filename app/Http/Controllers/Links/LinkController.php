<?php

namespace App\Http\Controllers\Links;

use App\Http\Controllers\Controller;
use App\Models\Lien;
use App\Models\Membre;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $links = Lien::latest()->paginate(200);
        $membres = Membre::all();
        return view('links.index', [
            'links' => $links,
            'membres' => $membres
        ]);
    }
}
