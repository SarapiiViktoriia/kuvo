<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->integer('pieces');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
