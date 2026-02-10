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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('mrn')->unique();
            $table->string('name');
            $table->string('phone');
            $table->text('address');
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('blood_type');
            $table->string('identity_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
