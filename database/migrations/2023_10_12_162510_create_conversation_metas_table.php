<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('conversation_metas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('conversation_id')->index();
            $table->string("property")->index();
            $table->text("content")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();

            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversation_metas');
    }
};
