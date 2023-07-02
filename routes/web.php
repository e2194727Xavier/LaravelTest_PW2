<?php

use App\Http\Controllers\BouteilleController;
use App\Http\Controllers\CellierController;
use App\Http\Controllers\SAQController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('update',[SAQController::class,'updateSAQ']);
    Route::get('index',[CellierController::class,'index'])->name('cellier.index');
Route::get('ajouterNouvelleBouteilleCellier',[CellierController::class,'create'])->name('cellier.create');
Route::post('ajouterNouvelleBouteilleCellier',[CellierController::class,'store']);
Route::post('ajouterNouvelleBouteilleCellier',[CellierController::class,'ajouterNouvelleBouteilleCellier'])->name('cellier.ajouterNouvelleBouteille');
Route::post('autocompleteBouteille',[BouteilleController::class,'autocompleteBouteille'])->name('cellier.autocomplete');

