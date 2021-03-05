<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('supplier_id');
            $table->date('arrival_date');
            $table->timestamps();
            $table->foreign('supplier_id')
            ->references('id')->on('companies');
        });
    }
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
