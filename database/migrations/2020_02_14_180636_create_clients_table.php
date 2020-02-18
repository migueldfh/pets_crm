<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('seller_id')->nullable();
            $table->integer('subsidiary_id');
            $table->string('type');
            $table->integer('person_type');
            $table->string('category');
            $table->string('name');
            $table->string('rfc');
            $table->string('street')->nullable();
            $table->string('ext_number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->string('currency')->nullable();
            $table->string('photo')->nullable();
            $table->string('owner')->nullable();
            $table->string('vet')->nullable();
            $table->string('admon')->nullable();
            $table->string('discount')->nullable();
            $table->integer('credit')->nullable();
            $table->integer('max_days_credit')->nullable();
            $table->integer('credit_limit')->nullable();
            $table->integer('max_credit_limit')->nullable();
            $table->string('account_holder')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
