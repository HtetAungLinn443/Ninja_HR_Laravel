<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckinCheckout extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'checkin_time',
        'checkout_time',
        'date',
    ];
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}