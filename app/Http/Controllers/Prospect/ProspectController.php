<?php

namespace App\Http\Controllers\Prospect;

use App\Http\Controllers\Controller;
use App\Models\Prospect;
use Illuminate\Http\Request;

class ProspectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $prospects = Prospect::latest()->paginate(200);
        return view('prospect.index', [
            'prospects' => $prospects
        ]);
    }
}
