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
        Schema::create('emprunts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exemplaire_id')->constrained()->onDelete('cascade');
            $table->dateTime('date_emprunt'); // Date de création de l'emprunt
            $table->dateTime('date_retour_prevue'); // Date limite (date_emprunt + 15 jours)
            $table->dateTime('date_retour_effectif')->nullable(); // Date réelle de retour
            $table->enum('status', ['validé', 'en attente', 'retard'])->default('en attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprunts');
    }
};
