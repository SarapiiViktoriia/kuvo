<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_group_id');
            $table->unsignedInteger('item_brand_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('image_url')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
