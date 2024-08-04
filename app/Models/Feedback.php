<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'email',
        'message',
        'source',
        'source_name',
        'rating'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
