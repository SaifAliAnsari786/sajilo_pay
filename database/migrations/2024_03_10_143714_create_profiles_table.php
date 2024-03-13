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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete("cascade")->onUpdate("cascade");
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('dob')->nullable();
            $table->unsignedBigInteger('staff_id');
            $table->string('joining_date')->nullable();
            $table->string('mobile_number_1')->unique();
            $table->string('mobile_number_2')->unique();
            $table->string('permanent_province')->nullable();
            $table->string('permanent_district')->nullable();
            $table->string('permanent_municipality')->nullable();
            $table->string('permanent_tole')->nullable();
            $table->string('current_province')->nullable();
            $table->string('current_district')->nullable();
            $table->string('current_municipality')->nullable();
            $table->string('current_tole')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('citizenship_front')->nullable();
            $table->string('citizenship_back')->nullable();
            $table->enum('is_active', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
