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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('code')->unique()->nullable();
            $table->enum('type', ['percentage', 'fixed']);
            $table->enum('mode', ['center', 'homecare'])->default('center');
            $table->unsignedBigInteger('value');
            $table->unsignedInteger('minimum_transaction')->nullable();
            $table->integer('quota')->nullable();
            $table->integer('used')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
