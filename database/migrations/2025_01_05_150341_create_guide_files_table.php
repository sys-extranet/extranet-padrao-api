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
        Schema::create('guide_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_id')->constrained('guides');
            $table->string('file_name');
            $table->string('temporary_file_name');
            $table->text('path_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_files');
    }
};
