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
            $table->integer('item_id')->unsigned();
            $table->integer('count');
            $table->integer('quantifiable_id')->unsigned();
            $table->string('quantifiable_type');
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::table('product_lists', function (Blueprint $table) {
            $table->dropForeign('product_lists_item_id_foreign');
        });
        Schema::dropIfExists('product_lists');
    }
}
