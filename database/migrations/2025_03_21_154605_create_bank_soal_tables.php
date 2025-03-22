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
        // Tabel Mata Pelajaran
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        // Tabel Bank Soal (parent)
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bank_soal');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->enum('tipe', ['pilihan_ganda', 'essay', 'kombinasi']);
            $table->text('deskripsi')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        // Tabel Soal (child dari bank_soal)
        Schema::create('soal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_soal_id')->constrained('bank_soal')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->enum('tipe', ['pilihan_ganda', 'essay']);
            $table->text('pilihan_a')->nullable();
            $table->text('pilihan_b')->nullable();
            $table->text('pilihan_c')->nullable();
            $table->text('pilihan_d')->nullable();
            $table->text('pilihan_e')->nullable();
            $table->enum('jawaban_benar', ['a', 'b', 'c', 'd', 'e'])->nullable(); // untuk pilihan ganda
            $table->text('kunci_jawaban')->nullable(); // untuk essay
            $table->text('pembahasan')->nullable();
            $table->integer('tingkat_kesulitan')->default(1);
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal');
        Schema::dropIfExists('bank_soal');
        Schema::dropIfExists('mata_pelajaran');
    }
};
