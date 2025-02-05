<?php

namespace App\Observers;

use App\Models\Transactions;
use App\Models\Pemasukan;
use Carbon\Carbon;

class TransactionObserver
{
    public function updated(Transactions $transaction)
    {
        // Jika status transaksi diubah menjadi "selesai"
        if ($transaction->status === 'selesai') {
            // Cek apakah sudah ada pemasukan untuk transaksi ini agar tidak duplikat
            if (!Pemasukan::where('transaction_id', $transaction->id)->exists()) {
                Pemasukan::create([
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->total_amount,
                    'description' => 'Pemasukan dari transaksi ' . $transaction->id,
                    'date' => Carbon::now()->toDateString(),
                ]);
            }
        }

        // Jika status transaksi sebelumnya "selesai" lalu berubah menjadi status lain
        if ($transaction->isDirty('status') && $transaction->getOriginal('status') === 'selesai' && $transaction->status !== 'selesai') {
            // Hapus pemasukan yang terkait dengan transaksi ini
            Pemasukan::where('transaction_id', $transaction->id)->delete();
        }
    }
}
