<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transactions_id')->constrained('transactions');
            $table->foreignId('produk_id')->constrained('produks');
            $table->date('rental_date');  // Tanggal rental ditentukan oleh user
            $table->date('return_date');  // Tanggal pengembalian diisi otomatis oleh sistem
            $table->integer('rental_days');  // Jumlah hari rental
            $table->string('location');
            $table->decimal('delivery_fee', 10, 2);  // Ongkir
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
