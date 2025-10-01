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
        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bio');
            $table->string('education');
            $table->string('teaching_experience');
            $table->integer('hourly_rate');
            $table->boolean("is_active")->default(true);
            $table->integer("rating")->default(0); // User rating
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor_profiles');
    }
};
