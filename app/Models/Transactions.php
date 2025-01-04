<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user;
use App\Models\Rentals;

class Transactions extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionsFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'order_name', 'order_whatsapp', 'installation_address', 'total_amount', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rentals::class);
    }

}
