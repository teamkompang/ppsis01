<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financings', function (Blueprint $table) {
            $table->string('sis_id');
            $table->string('header_id');
            $table->id('cid');
            $table->string('panel_update');
            $table->string('pic');
            $table->text('details');
            $table->dateTime('issue_date');
            $table->dateTime('update_date');
            $table->enum('status_comment', array('1', '0'))->default('1');
            $table->enum('status_case', array('1', '0','2'))->default('1');
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
        Schema::dropIfExists('financings');
    }
}
