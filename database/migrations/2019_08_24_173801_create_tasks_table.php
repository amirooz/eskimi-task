<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grand_grand_id')->nullable();
            $table->integer('grand_parent_id')->nullable();
            $table->integer('grand_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('user_id');
            $table->string('title');
            $table->integer('points');
            $table->integer('progress')->nullable();
            $table->boolean('is_done');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
