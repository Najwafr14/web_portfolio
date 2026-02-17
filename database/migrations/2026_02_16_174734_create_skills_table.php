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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('percentage')->nullable()->default(0);
            $table->string('category', 50)->nullable(); // Frontend, Backend, Design, DevOps
            $table->string('icon', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            // Soft Delete columns
            $table->timestamp('deleted_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            
            // Indexes
            $table->index('deleted_at');
            $table->index('category');
            $table->index('display_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};