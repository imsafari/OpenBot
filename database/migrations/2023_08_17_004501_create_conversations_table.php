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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('chat_id')->unique();
            $table->string('chat_type')->index();
            $table->string('title')->nullable();
            $table->string('state');
            $table->integer("first_message_id")->nullable();
            $table->integer("last_message_id")->nullable();
            $table->timestamp('last_activity_at')->useCurrent()->useCurrentOnUpdate();
            $table->timestamp('banned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
