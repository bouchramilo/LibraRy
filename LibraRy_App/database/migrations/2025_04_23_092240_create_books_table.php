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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('resume');
            $table->string('photo');
            $table->unsignedInteger('nbr_pages');
            $table->date('date_edition');
            $table->string('isbn')->unique();
            $table->string('language');
            $table->decimal('prix_emprunte', 8, 2);
            $table->decimal('prix_vente', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
