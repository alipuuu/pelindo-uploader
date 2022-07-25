<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelindoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelindo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_servicenow');
            $table->string('nama_aplikasi');
            $table->string('date');
            $table->string('pilih_server');
            $table->string('myfile');
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
        Schema::dropIfExists('pelindo');
    }
}
