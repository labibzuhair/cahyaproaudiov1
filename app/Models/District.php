<?php

namespace App\Models;

use App\Models\Transactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    /** @use HasFactory<\Database\Factories\DistrictFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'delivery_fee'
    ];
    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
