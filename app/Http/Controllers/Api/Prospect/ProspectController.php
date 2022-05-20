<?php

namespace App\Http\Controllers\Api\Prospect;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $prospects = Prospect::all();
        return $this->success($prospects, 'All prospects');
    }
}
