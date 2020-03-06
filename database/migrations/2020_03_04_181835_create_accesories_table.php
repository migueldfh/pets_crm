<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('desc_ticket');
            $table->string('name');
            $table->string('currency');
            $table->string('image')->nullable();
            $table->float('quantity');
            $table->dateTime('buying_date');
            $table->dateTime('expire_date');
            $table->float('buying_price');
            $table->float('selling_price');
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
        Schema::dropIfExists('accesories');
    }
}
