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
            $table->integer('university_id')->nullable();
            $table->integer('semester_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->longText('pdf')->nullable();
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