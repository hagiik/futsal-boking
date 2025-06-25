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
        Schema::create('field_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('field_id')->constrained()->cascadeOnDelete();
                $table->enum('day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
                $table->time('start_time');
                $table->time('end_time');
                $table->decimal('price_per_hour', 10, 2);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_schedules');
    }
};
