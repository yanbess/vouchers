<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PURCHASED = 'purchased';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'status'];

    /**
     * Get the phone associated with the user.
     */
    public function voucher()
    {
        return $this->hasOne(Voucher::class);
    }
}
