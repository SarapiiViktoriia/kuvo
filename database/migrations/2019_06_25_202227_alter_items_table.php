<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class AlterItemsTable extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('code', 'sku');
            $table->dropColumn('image_url');
            $table->unsignedInteger('supplier_id')->after('item_brand_id');
        });
    }
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('sku', 'code');
            $table->string('image_url')->nullable();
            $table->dropColumn('supplier_id');
        });
    }
}
