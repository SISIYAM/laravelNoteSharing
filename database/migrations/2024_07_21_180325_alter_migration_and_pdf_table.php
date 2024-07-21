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
        Schema::table('materials', function (Blueprint $table) {
            $table->string('role')->nullable()->after('author');
         });

         Schema::table('pdfs', function (Blueprint $table) {
            $table->string('author')->nullable()->after('pdf');
            $table->string('role')->nullable()->after('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('pdfs', function (Blueprint $table) {
            $table->dropColumn('author');
            $table->dropColumn('role');
        });
    }
};