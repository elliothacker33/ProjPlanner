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
        'closed_user_id',
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

    public function closed_by() : BelongsTo {
        return $this->belongsTo(User::class, 'closed_user_id')->withDefault([
            'name' => 'deleted_user',
        ]);
    }
}
