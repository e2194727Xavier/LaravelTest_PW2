<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vino__cellier', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bouteille')->nullable();
            $table->date('date_achat')->nullable();
            $table->string('garde_jusqua', 200)->nullable();
            $table->string('notes', 200)->nullable();
            $table->float('prix')->nullable();
            $table->integer('quantite')->nullable();
            $table->integer('millesime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('celliers');
    }
}
