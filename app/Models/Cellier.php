<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cellier extends Model
{
    use HasFactory;
    protected $table = 'vino__cellier';
    protected $fillable = [
        'id_bouteille',
        'date_achat', 
        'garde_jusqua',
        'notes',
        'prix',
        'quantite',
        'millesime'
    ];
}
