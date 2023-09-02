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
        Schema::create('groups', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('chat_id')->index();
            $table->unsignedBigInteger('conversation_id')->index();
            $table->string("title");
            $table->string("username")->nullable();
            $table->boolean("is_supergroup");
            $table->boolean("is_forum")->default(false);
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
