<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSupplierHasItemsTable extends Migration
{
    public function up()
    {
        Schema::create('supplier_has_items', function (Blueprint $table) {
            $table->integer('supplier_id')->unsigned();
            $table->integer('item_id')->unsigned();
        });
    }
    public function down()
    {
        Schema::dropIfExists('supplier_has_items');
    }
}
