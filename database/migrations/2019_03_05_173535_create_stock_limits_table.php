<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateStockLimitsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_limits', function (Blueprint $table) {
            $table->increments('id');
             $table->unsignedInteger('item_id');
             $table->integer('count');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('stock_limits');
    }
}
