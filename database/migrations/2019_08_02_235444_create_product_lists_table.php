<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductListsTable extends Migration
{
    public function up()
    {
        Schema::create('product_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->integer('count');
            $table->morphs('quantifiable');
            $table->timestamps();
            $table->foreign('item_id')
            ->references('id')->on('items');
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_lists');
    }
}
