<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tg_users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('chat_id')->index();
            $table->unsignedBigInteger('conversation_id')->index();
            $table->string("first_name");
            $table->string("last_name")->nullable();
            $table->string("username")->nullable();
            $table->string("phone")->nullable();
            $table->tinyText("language_code")->default("en");
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_users');
    }
};
