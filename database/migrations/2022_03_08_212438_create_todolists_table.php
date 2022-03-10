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
        Schema::create('todolist', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_completed')->default(0);
            $table->timestamp('ends_at');
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->index(['user_id', 'is_completed', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('todolist');
    }
};