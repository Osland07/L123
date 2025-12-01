<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // R01, R02
            
            // Foreign Keys
            $table->foreignId('risk_level_id')->constrained('risk_levels')->onDelete('cascade');
            $table->foreignId('required_factor_id')->nullable()->constrained('risk_factors')->onDelete('set null');
            
            $table->integer('min_other_factors')->default(0);
            $table->integer('max_other_factors')->nullable();
            $table->integer('priority');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};