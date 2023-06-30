<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vino__type', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('type', 20);
        });

        DB::table('vino__type')->insert([
            ['type'=>'Vin blanc'],
            ['type'=>'Vin rouge'],
            ['type'=>'Vin rosé'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vino__type');
    }
}
