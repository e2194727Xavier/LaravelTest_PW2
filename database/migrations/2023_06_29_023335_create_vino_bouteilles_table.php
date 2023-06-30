<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinoBouteillesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vino__bouteille', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom', 200)->nullable();
            $table->string('image', 200)->nullable();
            $table->string('code_saq', 50)->nullable();
            $table->string('pays', 50)->nullable();
            $table->string('description', 200)->nullable();
            $table->float('prix_saq')->nullable();
            $table->string('url_saq', 200)->nullable();
            $table->string('url_img', 200)->nullable();
            $table->string('format', 20)->nullable();
            $table->unsignedInteger('type')->nullable();
            $table->foreign('type')->references('id')->on('vino__type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vino__bouteille');
    }
}
