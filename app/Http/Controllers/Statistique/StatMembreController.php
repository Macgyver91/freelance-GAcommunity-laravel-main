<?php

namespace App\Http\Controllers\Statistique;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use DB;
use Illuminate\Support\Carbon;

class StatMembreController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    // Affiche les invitation direct des anges
    // public function index(){
    //     $membres = DB::table('membres')
    //     ->select("info->ange as angeId", DB::raw('count(*) as nbrInvitationDirect'))
    //     ->groupBy('info->ange')
    //     ->orderBy('nbrInvitationDirect', 'desc')
    //     ->get();
    //     $allMembres = Membre::all();
    //     // Position d'un ange par rapport aux autres ange (rang)
    //     $a=0;
    //     return view('statistique.statMembreTribu',[
    //         'membres'=>$membres,
    //         'allMembres'=>$allMembres,
    //         'a'=>$a
    //     ]);
    // }

    public function index(){

        $allMembres = DB::select( DB::raw( "SELECT membres.id, membres.info
            FROM membres
            WHERE membres.status = 'membre' " )
        );

        $grouped     = array();
        $indirect = array();

        foreach ($allMembres as $items) {
            # code...

            $invite = DB::select( DB::raw( "SELECT COUNT( JSON_EXTRACT( info, '$.ange' ) ) as count_invite, JSON_EXTRACT( info, '$.ange' ) as userId
                                            FROM membres
                                            WHERE ( status = 'prospect' AND JSON_EXTRACT( info, '$.ange' ) = $items->id AND JSON_EXTRACT( info, '$.status_invitation' ) = 'prospect' )
                                            GROUP BY JSON_EXTRACT( info, '$.ange' );"
                                        )
                                );

            if ( !empty($invite) ) {
                # code...
                foreach( $invite as $item ) {
                    $invite_indirect = DB::select( DB::raw( "SELECT COUNT( JSON_EXTRACT( info, '$.status_invitation' ) ) as count_indirects, JSON_EXTRACT( info, '$.ange' ) as userId
                                FROM membres
                                WHERE ( status = 'prospect' AND JSON_EXTRACT( info, '$.ange' ) = $item->userId AND JSON_EXTRACT( info, '$.status_invitation' ) = 'membre' )
                                GROUP BY JSON_EXTRACT( info, '$.ange' );"
                            )
                    );
                    if ( $invite_indirect ) {
                        # code...
                        foreach( $invite_indirect as $invits ) {
                            if ( $invits->userId === $item->userId ) {
                                # code...

                                array_push($grouped, [
                                    "prenom"                => json_decode($items->info)->prenom,
                                    "nom"                   => json_decode($items->info)->nom,
                                    "telephone"             => json_decode($items->info)->telephone,
                                    "userId"                => (int)$item->userId,
                                    "count_invite"          => (int) $item->count_invite,
                                    "count_indirects"       => (int) $invits->count_indirects,
                                ]);

                            }

                        }
                    } else {
                        # code...

                        array_push($grouped, [
                            "prenom"                => json_decode($items->info)->prenom,
                            "nom"                   => json_decode($items->info)->nom,
                            "telephone"             => json_decode($items->info)->telephone,
                            "userId"                => (int)$item->userId,
                            "count_invite"          => (int) $item->count_invite,
                            "count_indirects"       => 0,
                        ]);

                    }

                }

            }


        }

        $a=0;
        $count=0;
        $total = 0;

        return view('statistique.statMembreTribu', compact("allMembres", "invite", "a", "grouped", "count", "indirect", "total"));

    }

}



