<?php

namespace App\Http\Controllers\Api\Membre;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Traits\ApiResponser;

class MembreController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $membres = Membre::all();
        return $this->success($membres, 'All \'membres\'');
    }
}
