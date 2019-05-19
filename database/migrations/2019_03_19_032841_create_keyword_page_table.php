<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keyword_page', function (Blueprint $table) {
            $table->primary(['keyword_id', 'page_id']);
            $table->unsignedInteger('keyword_id');
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');
            $table->unsignedInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
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
        Schema::dropIfExists('keyword_page');
    }
}
