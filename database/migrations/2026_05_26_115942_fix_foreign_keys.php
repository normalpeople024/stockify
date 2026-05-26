<?php
// database/migrations/2024_01_01_000010_fix_foreign_keys.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix stock_transactions
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('restrict'); // tetap restrict, tapi soft delete tidak trigger ini
        });

        // Fix product_attributes
        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade'); // atribut ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::table('stock_transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });

        Schema::table('product_attributes', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
