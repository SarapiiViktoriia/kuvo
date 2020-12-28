<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateItemGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('item_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unisgned()->nullable();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('item_groups');
    }
}
