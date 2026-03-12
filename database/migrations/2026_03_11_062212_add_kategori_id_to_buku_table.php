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
    Schema::table('buku', function (Blueprint $table) {
        // Tambahkan kolom KategoriID sebagai Foreign Key
        // unsignedBigInteger karena biasanya ID menggunakan tipe data ini
        $table->unsignedBigInteger('KategoriID')->nullable()->after('BukuID');
        
        // Opsional: Hubungkan secara resmi ke tabel kategoribuku
        $table->foreign('KategoriID')->references('KategoriID')->on('kategoribuku')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('buku', function (Blueprint $table) {
        $table->dropForeign(['KategoriID']);
        $table->dropColumn('KategoriID');
    });
}
};
