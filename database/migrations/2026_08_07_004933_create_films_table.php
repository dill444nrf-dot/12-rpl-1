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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->integer('durasi');
            $table->decimal('rating');
            $table->string('desc');
            $table->date('tahun_rilis');
            $table->string('poster');
            $table->string('sutradara');
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
            //$table->foreignId('id_aktor')->constrained('aktors')->onDelete('cascade');
            $table->timestamps();
        });

       Schema::create('aktor_film', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_aktor')->constrained('aktors');
            $table->foreignId('id_film')->constrained('films');
            $table->timestamps();
            $table->unique(['id_aktor','id_film']);
       });
       }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktor_film');
        Schema::dropIfExists('films');
    }
};
