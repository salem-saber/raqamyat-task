<?php

namespace PaymentApp\TransactionModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PaymentApp\UserModule\Models\User;

class Transaction extends Model
{

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'paid_amount' => 'double',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'currency',
        'mobile',
        'status',
        'payment_date',
        'provider_type',
        'provider_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_email', 'email');
    }
}
