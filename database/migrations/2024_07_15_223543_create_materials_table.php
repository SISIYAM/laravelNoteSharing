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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_id')->references('id')->on('universities')->onDelete('cascade');
            $table->foreignId('semester_id')->references('id')->on('semisters')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('pdf')->nullable();
            $table->integer('status')->default(0);
            $table->string('author')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};