<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'status',
        'description',
        'deadline',
    ];

    public function assigned(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function creator():BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_user_id' );
    }
}
