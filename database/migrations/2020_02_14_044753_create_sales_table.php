<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subsidiary_id');
            $table->integer('client_id');
            $table->integer('pet_id');
            $table->integer('seller_id');
            $table->string('folio');
            $table->string('currency');
            $table->string('conditions');
            $table->dateTime('pickup');
            $table->string('shift');
            $table->string('code');
            $table->double('quantity', 8, 2);
            $table->json('products');
            $table->double('discount', 4, 2);
            $table->double('subtotal', 8, 2);
            $table->double('total', 8, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
