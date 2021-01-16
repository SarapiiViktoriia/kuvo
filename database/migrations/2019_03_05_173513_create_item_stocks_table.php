<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemStocksTable extends Migration
{
    public function up()
    {
        Schema::create('item_stocks', function (Blueprint $table) {
            $table->increments('id');
             $table->unsignedInteger('item_id');
             $table->unsignedInteger('inventory_unit_id');
             $table->integer('count');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('item_stocks');
    }
}
