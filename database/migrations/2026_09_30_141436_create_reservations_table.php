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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_profile_id')->constrained('tutor_profiles')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('reservation_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('price');
            $table->string('meeting_link')->nullable();
            $table->enum('status',['ongoing', 'unpaid', 'done', 'cancelled', 'accepted','rejected','pending'])->default('ongoing');
            $table->foreignId('rating_id')->nullable()->constrained('ratings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // 2. Drop the table
        Schema::dropIfExists('reservations');

        // 3. Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }
};
