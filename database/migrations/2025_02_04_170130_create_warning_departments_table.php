<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warning_departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warning_id');
            $table->unsignedBigInteger('department_id');

            $table->foreign('warning_id')->references('id')->on('warnings');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warning_departments');
    }
};
