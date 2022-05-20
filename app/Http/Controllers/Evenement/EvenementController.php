<?php

namespace App\Http\Controllers\Evenement;

use App\Http\Controllers\Controller;
use App\Models\Abandon;
use App\Models\Evenement;
use App\Models\EvenementMembre;
use App\Models\GrandGroupe;
use App\Models\Lien;
use App\Models\Membre;
use App\Models\StaffList;
use App\Models\StaffMembre;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class EvenementController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create_events', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_events', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_events', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evenements = Evenement::get();
        return view("evenement.index", [
            "evenements" => $evenements
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $membres = Membre::get();
        $grand_groupes = GrandGroupe::get();
        $abandons = Abandon::get();
        return view("evenement.create", [
            "membres" => $membres,
            "grand_groupes" => $grand_groupes,
            "abandons" => $abandons
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules_date = 'required|date';
        // Schema validation for request
        $this->validate($request, [
            'type' => ['required', Rule::in(['N1', 'N2', 'N3', 'N4'])],
            'numero_week_end' => 'required|integer',
            'pays' => ['required', Rule::in(['France'])],
            'ville' => 'required|string',
            'centre' => 'required|string',
            'date_debut' => $rules_date,
            'date_fin' => $rules_date,
            'lieu' => 'required|string',
            'adresse' => 'required|string',
            'coach' => 'required|string',
            'tarif' => 'required|between:0,99.99'
        ]);

        // Try to store all information from request body
        try {
            Evenement::create([
                'type' => $request->type,
                'numero_week_end' => $request->numero_week_end,
                'pays' => $request->pays,
                'ville' => $request->ville,
                'centre' => $request->centre,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'lieu' => $request->lieu,

                'adresse' => $request->adresse,
                'coach' => $request->coach,
                'tarif' => $request->tarif,

            ]);

            // redirect to list of staff if success
            return redirect()->route('admin.all_events')->with("message", "Une évènement a été créée avec succès");
        } catch (QueryException $exception) {
            // catch exception
            // throw error if error
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Evenement::find($id);
        $participants = EvenementMembre::where('evenement_id', $id)->get();
        $arrayMembre = EvenementMembre::where('evenement_id', $id)->get()->toArray();
        $membres = Membre::get();
        $grand_groupes = GrandGroupe::get();
        $debut = Carbon::parse($event->date_debut)->format('Y-m-d');
        $fin = Carbon::parse($event->date_fin)->format('Y-m-d');

        $nbrMembre = count($arrayMembre);

        // Send null to the view if non-existing grand groupe
        $gg = Evenement::find($id)->grand_groupe;
        $grand_groupe = isset($gg) ? $gg : null;

        $abandons = Abandon::where('evenement_id', $id)->get();
        $staffs = StaffList::get();
        $staffParticipe = StaffList::where('evenement_id', $id)->first();
        $staffmembres = isset($staffParticipe) ? StaffMembre::where('staff_list_id', $staffParticipe->id)->get() : [];

        return view("evenement.show", [
            "event" => $event,
            "participants" => $participants,
            "membres" => $membres,
            "grand_groupes" => $grand_groupes,
            "grand_groupe" => $grand_groupe,
            "abandons" => $abandons,
            "staffs" => $staffs,
            "staffParticipe" => $staffParticipe,
            "debut" => $debut,
            "fin" => $fin,
            "staffmembres" => $staffmembres,
            "arrayMembre" => $arrayMembre,
            'nbrMembre' => $nbrMembre
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Query & inject it to the view
        $evenement = Evenement::find($id);
        $membres = Membre::get();
        $grand_groupes = GrandGroupe::get();
        $abandons = Abandon::get();

        // Parse date & inject it to the view
        $date_debut = Carbon::parse($evenement->date_debut)->format('Y-m-d');
        $date_fin = Carbon::parse($evenement->date_fin)->format('Y-m-d');

        return view("evenement.edit", [
            "evenement" => $evenement,
            "membres" => $membres,
            "grand_groupes" => $grand_groupes,
            "abandons" => $abandons,
            "date_debut" => $date_debut,
            "date_fin" => $date_fin
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evenement $event)
    {
        $rules_date = 'required|date';

        // Schema validation for request
        $this->validate($request, [
            'type' => ['required', Rule::in(['N1', 'N2', 'N3', 'N4'])],
            'numero_week_end' => 'required|integer',
            'pays' => ['required', Rule::in(['France'])],
            'ville' => 'required|string',
            'centre' => 'required|string',
            'date_debut' => $rules_date,
            'date_fin' => $rules_date,
            'lieu' => 'required|string',
            'adresse' => 'required|string',
            'coach' => 'required|string',
            'tarif' => 'required|between:0,99.99'
        ]);

        try {
            $event->type = $request->type;
            $event->numero_week_end = $request->numero_week_end;
            $event->pays = $request->pays;
            $event->ville = $request->ville;
            $event->centre = $request->centre;
            $event->date_debut = $request->date_debut;
            $event->date_fin = $request->date_fin;
            $event->lieu = $request->lieu;

            $event->adresse = $request->adresse;
            $event->coach = $request->coach;
            $event->tarif = $request->tarif;

            $event->save();
            return redirect()->route('admin.all_events')->with("message", "Une évènement a été modifiée avec succès");
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), "Integrity constraint violation")) {
                return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
            }
            return back()->with("error", "Une erreur s'est produit, essayer à nouveau");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evenement $event)
    {
        $event->delete();

        return back()->with("message", "Une évènement a été supprimée avec succès");
    }
}
