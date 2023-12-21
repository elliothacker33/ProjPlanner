<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'content',
        'user_id',
        'task_id',
        'submit_date',
        'last_edited',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function task():BelongsTo
    {
        return $this->belongsTo(Task::class,'task_id');
    }

}
