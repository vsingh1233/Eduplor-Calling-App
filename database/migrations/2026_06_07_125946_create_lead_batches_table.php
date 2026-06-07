<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lead_batches', function (Blueprint $table) {
            $table->id();
            // The Caller assigned to this batch
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            // The Admin or Caller who actually uploaded the file
            $table->foreignId('uploader_id')->constrained('users')->cascadeOnDelete(); 
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lead_batches');
    }
};