<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionChanges extends Model
{

    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'field',
        'old_value',
        'new_value',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
