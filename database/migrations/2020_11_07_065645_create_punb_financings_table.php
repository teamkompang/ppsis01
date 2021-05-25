<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePunbFinancingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('punb_financings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('detail');
            $table->string('user_created');
            $table->timestamps();
            $table->string('user_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punb_financings');
    }
}
