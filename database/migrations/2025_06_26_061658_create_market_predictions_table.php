<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketPredictionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('market_predictions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_url')->nullable();
            $table->text('description');
             $table->string('market_sentiment')->nullable();
            $table->text('global_cues')->nullable();
            $table->text('volatility_alert')->nullable();
            $table->string('support_levels')->nullable();
            $table->string('resistance_levels')->nullable();
            $table->string('range')->nullable(); // e.g., "23500 - 23700"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_predictions');
    }
}
