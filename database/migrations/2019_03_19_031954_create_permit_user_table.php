<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermitUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permit_group', function (Blueprint $table) {
            $table->primary(['permit_id', 'groups_id']);
            $table->unsignedInteger('permit_id');
            $table->foreign('permit_id')->references('id')->on('permits')->onDelete('cascade');
            $table->unsignedInteger('groups_id');
            $table->foreign('groups_id')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::dropIfExists('permit_user');
    }
}
