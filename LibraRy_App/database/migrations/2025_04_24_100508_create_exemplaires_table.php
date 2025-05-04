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
        Schema::create('exemplaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->string('code_serial_exemplaire')->unique();
            $table->string('rayon');
            $table->string('etagere');
            $table->boolean('disponible')->default(true);
            $table->enum('etat', ['neuf', 'bon', 'usé', 'endommagé'])->default('neuf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exemplaires');
    }
};
