<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'published_at',
        'status',
        'blocked_at',
        'blocked_comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
