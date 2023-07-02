<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Bouteille extends Model
{
    use HasFactory;
    protected $table = "vino__bouteille";
    protected $fillable = ['nom', 'type_id', 'image', 'code_saq', 'pays_id', 'description', 'prix_saq', 'url_saq', 'url_img', 'format'];

    
    public function getListeBouteille()
    {
        return self::all();
    }
    
    public function getListeBouteilleCellier()
    {
        return $this->select(
            'cellier.id as id_bouteille_cellier',
            'cellier.id_bouteille',
            'cellier.date_achat',
            'cellier.garde_jusqua',
            'cellier.notes',
            'cellier.prix',
            'cellier.quantite',
            'cellier.millesime',
            'bouteille.id',
            'bouteille.nom',
            'type.type',
            'bouteille.image',
            'bouteille.code_saq',
            'bouteille.url_saq',
            'bouteille.pays',
            'bouteille.description'
        )
            ->from('vino__cellier as cellier')
            ->join('vino__bouteille as bouteille', 'cellier.id_bouteille', '=', 'bouteille.id')
            ->join('vino__type as type', 'bouteille.type', '=', 'type.id')
            ->get();
    
    }
    
    public function autocomplete($nom, $nb_resultat = 10)
    {
        return $this->select('id', 'nom')
            ->whereRaw('LOWER(nom) like LOWER(?)', ['%' . $nom . '%'])
            ->limit($nb_resultat)
            ->get();
    }
    
    public function ajouterBouteilleCellier($data)
    {
        DB::table('vino__cellier')->insert($data);    }
    
    public function modifierQuantiteBouteilleCellier($id, $nombre)
    {
        return $this->where('id', $id)->increment('quantite', $nombre);
    }

    
}
