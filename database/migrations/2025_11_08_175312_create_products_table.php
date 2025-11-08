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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->longText('long_description')->nullable();
            $table->string('slug')->unique();
            $table->string('sku') -> unique();
            $table->decimal('price', 10 );
            $table->decimal('cost_price', 10) -> nullable();
            $table->decimal('compare_price', 10)->nullable();
            $table->decimal('discount_percentage', 5, )->nullable();
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->text('description')->nullable();
            $table->boolean('track_stock')->default(true);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'on_backorder'])
                ->default('in_stock');
            $table->decimal('weight')->nullable();
            $table->decimal('length')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->string('main_image')->nullable();
            $table->json('images')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('view_count')->default(0);
            $table->integer('order')->default(0);
            $table->json('attributes')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->index('category_id');
            $table->index('sku');
            $table->index('is_active');
            $table->index('is_featured');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
