<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bouteille extends Model
{
    use HasFactory;
    protected $table = "vino__bouteille";
    protected $fillable = ['nom', 'type', 'image', 'code_saq', 'pays', 'description', 'prix_saq', 'url_saq', 'url_img', 'format'];
}
