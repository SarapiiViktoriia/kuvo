<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemBundlingsTable extends Migration
{
    public function up()
    {
        Schema::create('item_bundlings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('inventory_unit_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('item_bundlings');
    }
}
