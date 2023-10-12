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
        Schema::create('tg_user_metas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('tg_user_id')->index();
            $table->string("property")->index();
            $table->text("content")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();

            $table->foreign('tg_user_id')->references('id')->on('tg_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tg_user_metas');
    }
};
