<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rentals;
use App\Models\District;
use App\Models\Pemasukan; // Tambahkan model Pemasukan
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_name',
        'order_whatsapp',
        'installation_address',
        'district_id',
        'total_amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rentals::class, 'transactions_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    // Deteksi perubahan status transaksi
    public static function boot()
    {
        parent::boot();

        static::updating(function ($transaction) {
            // Jika status berubah dari "selesai" ke status lain
            if ($transaction->isDirty('status') && $transaction->getOriginal('status') === 'selesai' && $transaction->status !== 'selesai') {
                // Hapus pemasukan yang terkait dengan transaksi ini
                Pemasukan::where('transaction_id', $transaction->id)->delete();
            }
        });
    }
}
