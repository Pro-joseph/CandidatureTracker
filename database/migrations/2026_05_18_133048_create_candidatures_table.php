<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('candidatures', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('entreprise');
    $table->string('poste');
    $table->string('url')->nullable();
    $table->enum('statut', ['to_review','interview_scheduled','offer_received','rejected','abandoned'])->default('to_review');
    $table->enum('priorite', ['high','medium','low'])->default('medium');
    $table->text('notes')->nullable();
    $table->date('date_candidature');
    $table->timestamps();
    $table->softDeletes();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};