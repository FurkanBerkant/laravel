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
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });

        // 2. PRODUCTS Tablosu (Geri Al)
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });

        // 3. CATEGORIES Tablosu (Geri Al)
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });
    }
};
