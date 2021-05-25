<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpsisHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppsis_headers', function (Blueprint $table) {
            $table->id('sis_id');
            $table->string('header_id')->references('ID')->on('ld_ststrackingheader');
            $table->string('product');
            $table->string('case_no');
            $table->string('status');
            $table->string('user_created');
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
        Schema::dropIfExists('ppsis__headers');
    }
}
