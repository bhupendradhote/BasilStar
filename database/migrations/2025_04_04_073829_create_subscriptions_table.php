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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('org_id')->constrained('organizations')->onDelete('cascade');
            // $table->enum('plan_type', ['standard', 'professional', 'premium', 'elite', 'ultimate']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();

            $table->unsignedBigInteger('user_id_active')->virtualAs("IF(status = 'active', user_id, NULL)");
            $table->unique('user_id_active', 'user_id_active_unique');
            // $table->unsignedBigInteger('org_id_active')->virtualAs("IF(status = 'active', org_id, NULL)");
            // $table->unique('org_id_active', 'org_id_active_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
