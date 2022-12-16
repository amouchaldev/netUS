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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->unsignedBigInteger('recipient_id')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('users');
            $table->unique(['sender_id', 'recipient_id']);
            $table->unique(['recipient_id', 'sender_id']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
};
