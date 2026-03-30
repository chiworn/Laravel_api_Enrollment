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
        Schema::create('tb_enrollment', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            $table->foreignId('course_id')->constrained('tb_course')->onDelete('cascade');
            $table->foreignId('timeslot_id')->constrained('tb_timeslot')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('tb_ternslot')->onDelete('cascade');
            $table->foreignId('price_id')->constrained('tb_price')->onDelete('cascade');

            $table->string('Frist_name', 90);
            $table->string('last_name', 100);
            $table->string('phone', 50);
            $table->string('email', 100);
            $table->string('status')->nullable();
            
            $table->timestamps(); // creates created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_enrollment');
    }
};
