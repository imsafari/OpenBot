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
        Schema::create('group_metas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('group_id')->index();
            $table->string("property")->index();
            $table->text("content")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_metas');
    }
};
