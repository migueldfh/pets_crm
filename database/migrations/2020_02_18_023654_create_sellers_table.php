<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subsidiary_id');
            $table->string('name');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('rfc');
            $table->string('account');
            $table->string('personal_email');
            $table->string('office_email');
            $table->string('cellphone');
            $table->string('shift');
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
        Schema::dropIfExists('sellers');
    }
}
