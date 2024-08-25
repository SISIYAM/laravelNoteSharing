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
        Schema::table('semisters', function (Blueprint $table) {
            $table->unsignedTinyInteger('department_id')->nullable();
        });

        // create department table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('university_id')->nullable();
            $table->string('department')->nullable();
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
        Schema::table('semisters', function (Blueprint $table) {
            //
        });
    }
};
