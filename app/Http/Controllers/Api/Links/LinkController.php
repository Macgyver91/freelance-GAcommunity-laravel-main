<?php

namespace App\Http\Controllers\Api\Links;

use App\Http\Controllers\Controller;
use App\Models\Lien;
use App\Models\Membre;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $links = Lien::all();
        $membres = Membre::all();
        return $this->success([
            'links' => $links,
            'membres' => $membres
        ], 'All links and membres');
    }
}
