<?php

namespace App\Http\Controllers\Api\BigGroup;

use App\Http\Controllers\Controller;
use App\Models\GrandGroupe;
use App\Traits\ApiResponser;

class BigGroupController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $bigGroupes = GrandGroupe::get();
        return $this->success($bigGroupes, 'All BigGroupes');
    }
}