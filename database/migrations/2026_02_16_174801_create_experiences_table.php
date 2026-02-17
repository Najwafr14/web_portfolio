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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('position', 150);
            $table->string('company', 150);
            $table->date('start_date');
            $table->date('end_date')->nullable(); // NULL jika masih bekerja
            $table->text('description')->nullable();
            $table->json('achievements')->nullable(); // Store as JSON in PostgreSQL
            $table->boolean('is_current')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            // Soft Delete columns
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            
            // Indexes
            $table->index('deleted_at');
            $table->index('is_current');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};