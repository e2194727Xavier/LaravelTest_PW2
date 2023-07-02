<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use Illuminate\Http\Request;

class BouteilleController extends Controller
{
 
    public function autocompleteBouteille(Request $request)
    {
        $bte = new Bouteille();
        $listeBouteille = $bte->autocomplete($request->input('nom'));
        
        return response()->json($listeBouteille);
    }

    public function ajouterNouvelleBouteilleCellier(Request $request)
    {    
        
        $bte = new Bouteille();
        $resultat = $bte->ajouterBouteilleCellier($request->all());
        
        return response()->json($resultat);
    }

    public function boireBouteilleCellier(Request $request)
    {
        $bte = new Bouteille();
        $resultat = $bte->modifierQuantiteBouteilleCellier($request->input('id'), -1);
        
        return response()->json($resultat);
    }

    public function ajouterBouteilleCellier(Request $request)
    
    {
        $data = $request->except('_token');
    
    $bte = new Bouteille();
    $resultat = $bte->ajouterBouteilleCellier($data);
    
    return response()->json($resultat);
    }
}
