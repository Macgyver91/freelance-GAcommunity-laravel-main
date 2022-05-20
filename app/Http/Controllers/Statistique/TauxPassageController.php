<?php

namespace App\Http\Controllers\Statistique;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\EvenementMembre;
use App\Models\Membre;
use App\Models\StaffList;
use DB;
use Illuminate\Http\Request;

class TauxPassageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(){
        
        $taux_members = Membre::where("status", "=", "membre")->get(["id"]);
        $all_event = Evenement::all()->count();
        $taux_members_in_event = DB::select( DB::raw( "SELECT COUNT(evenement_membres.evenement_id) as event_participate, membres.id, membres.info 
                                                                            FROM evenement_membres 
                                                                            LEFT JOIN membres 
                                                                            ON membres.id = evenement_membres.membre_id 
                                                                            GROUP BY evenement_membres.membre_id ; " ) );
        
        $membre_petit_group = DB::select( DB::raw( "SELECT COUNT(evenement_membres.evenement_id) as event_participate, membres.id, membres.info 
                                                    FROM evenement_membres 
                                                    LEFT JOIN membres 
                                                    ON membres.id = evenement_membres.membre_id 
                                                    GROUP BY evenement_membres.membre_id ; " ) );
        
        $jsonArray = "";
        $count = 0;
        
        return view('statistique.tauxPassage', compact("taux_members_in_event", "all_event", "jsonArray", "count"));
    }
}