<?php

namespace App\Http\Controllers\Api\Statistique;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Traits\ApiResponser;
use DB;
use Illuminate\Support\Carbon;

class StatMembreController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    // Affiche les invitation direct des anges
    public function index(){
        $membres = DB::table('membres')
        ->select("info->ange as angeId", DB::raw('count(*) as nbrInvitationDirect'))
        ->groupBy('info->ange')
        ->orderBy('nbrInvitationDirect', 'desc')
        ->get();
        $allMembres = Membre::all();
        // Position d'un ange par rapport aux autres ange (rang)
        $a=0;
        return $this->success([
            'membres'=>$membres,
            'allMembres'=>$allMembres,
            'a'=>$a
        ], 'Invitations');
    }
}