<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('condition_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // 商品情報
            $table->string('name');
            $table->text('description');
            $table->string('brand')->nullable();
            $table->integer('price');
            $table->string('image')->nullable();

            // 出品ステータス
            $table->enum('status', ['on_sale', 'sold', 'draft'])->default('on_sale');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
