<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sis_id');
            $table->string('header_id')->references('ID')->on('ld_ststrackingheader');
            $table->string('cid');
            $table->text('details');
            $table->string('status_case');
            $table->string('company_sender');
            $table->string('person_sender');
            $table->string('company_receiver');
            $table->string('person_receiver');
            $table->string('status_email');
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
        Schema::dropIfExists('email_cases');
    }
}
