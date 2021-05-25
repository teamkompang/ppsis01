<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVlosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vlos', function (Blueprint $table) {
            $table->string('header_id');
            $table->id('cid');
            $table->string('panel_update');
            $table->string('pic');
            $table->text('details');
            $table->dateTime('issue_date');
            $table->dateTime('update_date');
            $table->enum('status_comment', array('Active', 'Hide'))->default('Active');
            $table->enum('status_case', array('Active', 'Closed','Re-Opened'))->default('Active');
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
        Schema::dropIfExists('vlos');
    }
}
