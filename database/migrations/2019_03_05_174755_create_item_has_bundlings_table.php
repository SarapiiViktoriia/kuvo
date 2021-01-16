<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemHasBundlingsTable extends Migration
{
    public function up()
    {
        Schema::create('item_has_bundlings', function (Blueprint $table) {
            $table->integer('item_id')->unsigned();
            $table->integer('item_bundling_id')->unsigned();
        });
    }
    public function down()
    {
        Schema::dropIfExists('item_has_bundlings');
    }
}
