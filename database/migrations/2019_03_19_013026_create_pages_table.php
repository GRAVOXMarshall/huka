<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->text('title');
            $table->text('description');
            $table->string('link', 191)->unique();
            $table->enum('type', ['B', 'F']);
            $table->integer('parent_layout')->nullable();
            $table->boolean('active');
            $table->boolean('main');
            $table->boolean('user_page');
            $table->longtext('components')->nullable();
            $table->longtext('styles')->nullable();
            $table->longtext('assets')->nullable();
            $table->longtext('css')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
