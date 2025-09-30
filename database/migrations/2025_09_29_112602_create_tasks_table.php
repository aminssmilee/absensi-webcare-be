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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');                           // Judul tugas
            $table->boolean('is_done')->default(false);        // Status tugas (selesai/belum)
            $table->text('comment')->nullable();               // Komentar user (satu kolom saja)

            // User yang ditugaskan
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            // Admin pembuat tugas
            $table->foreignId('created_by')
                ->nullable() // ✅ dibikin nullable biar insert manual tidak error
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
