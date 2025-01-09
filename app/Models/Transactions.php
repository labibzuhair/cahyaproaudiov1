<?php

namespace App\Models;

use App\Models\user;
use App\Models\Rentals;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionsFactory> */
    use HasFactory;
    use HasFactory;
    protected $fillable = ['user_id', 'order_name', 'order_whatsapp', 'installation_address', 'district_id', 'total_amount', 'status'];
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

}
