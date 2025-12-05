<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
use HasFactory;

    protected $fillable = [
        'user_id', // Tambahkan ini
        'category_id',
        'item_name',
        'price',
        'quantity',
        'total',
        'type',
        'transaction_date',
        'notes'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'transaction_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            // Auto calculate total
            $transaction->total = $transaction->price * $transaction->quantity;

            // Auto set user_id jika belum di-set
            if (empty($transaction->user_id)) {
                $transaction->user_id = auth()->id();
            }
        });

        static::updating(function ($transaction) {
            // Auto calculate total saat update
            $transaction->total = $transaction->price * $transaction->quantity;
        });
    }
}