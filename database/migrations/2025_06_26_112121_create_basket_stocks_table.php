<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('basket_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('basket_id');

            $table->string('symbol');
            $table->decimal('buy_price', 10, 2);
            $table->decimal('target_price', 10, 2);
            $table->decimal('stop_loss', 10, 2);

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('basket_id')
                ->references('id')
                ->on('baskets')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('basket_stocks');
    }
};
