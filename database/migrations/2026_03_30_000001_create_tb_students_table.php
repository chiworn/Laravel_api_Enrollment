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
        Schema::create('tb_students', function (Blueprint $table) {
            $table->id();
            $table->string('frist_name', 255);
            $table->string('last_name', 255);
            $table->string('email_stu')->unique();
            $table->string('phone_num', 100);
            $table->string('gender');
            $table->timestamp('creat_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_students');
    }
};
