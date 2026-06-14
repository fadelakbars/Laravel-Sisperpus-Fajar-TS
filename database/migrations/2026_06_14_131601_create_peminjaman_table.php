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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId('buku_id')->constrained(table: 'buku')->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo')->index();
            $table->date('tanggal_kembali')->nullable();
            $table->decimal('jumlah_denda', 10, 2)->default(0);
            $table->enum('status_peminjaman', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam')->index();
            $table->timestamps();

            $table->index(['anggota_id', 'status_peminjaman']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
