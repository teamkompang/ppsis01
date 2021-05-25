<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecureParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group');
            $table->string('param_value');
            $table->string('value_details');
            $table->text('description');
            $table->timestamps();
            $table->string('user_lastmaintain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secure_params');
    }
}
