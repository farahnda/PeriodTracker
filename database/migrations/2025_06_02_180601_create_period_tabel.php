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
        Schema::create('period_tabel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('start_date')->comment('Tanggal mulai menstruasi');
            $table->date('end_date')->nullable()->comment('Tanggal selesai menstruasi');
            $table->integer('cyclelength')->comment('Panjang siklus dalam hari');
            $table->integer('periodlength')->comment('Lama menstruasi dalam hari');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('period_tabel');
    }
};
