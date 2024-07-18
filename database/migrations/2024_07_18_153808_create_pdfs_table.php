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
        Schema::create('pdfs', function (Blueprint $table) {
            $table->id();
            $table->integer('material_id')->nullable();
            $table->timestamps();
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdfs');
        Schema::table('materials', function (Blueprint $table) {
            $table->json('pdf')->nullable()->after('description');
         });
    }
};
