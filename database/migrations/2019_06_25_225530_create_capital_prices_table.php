<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCapitalPricesTable extends Migration
{
    public function up()
    {
        Schema::create('capital_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->integer('value');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('capital_prices');
    }
}
