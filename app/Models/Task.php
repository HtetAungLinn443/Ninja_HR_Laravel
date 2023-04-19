<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function members()
    {
        return $this->belongsToMany(User::class, 'task_members', 'task_id', 'user_id');
    }
}
