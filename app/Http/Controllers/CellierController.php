<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Cellier;
use Illuminate\Http\Request;

class CellierController extends Controller
{
    public function index()
    {
        
            $bouteille = new Bouteille;
            $product = $bouteille->getListeBouteilleCellier();
            return view('cellier.cellier', ['product'=>$product]); /* cellier : le nom du dossier et apres le point le nom du fichier */

    }

    public function create(){
        
        return view('cellier.ajouter');
    }


    public function store(Request $request)

    {
        return $request;
        $store = new BouteilleController;
        $store -> ajouterNouvelleBouteilleCellier($request);
        return redirect(route('cellier.index') );
    }

}
