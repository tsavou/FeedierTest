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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('set null');
            $table->string('email')-> nullable();
            $table->text('message');
            $table->enum('source', ['EXTERNAL', 'DASHBOARD'])->default('DASHBOARD');

            $table->timestamps();

            $table->unique(['user_id', 'created_at']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
