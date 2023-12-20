<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $casts = [
        'deadline' => 'datetime', 
    ];

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'user_id',
        'is_archived',
    ];

    protected $hidden = ['tsvectors'];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function coordinator() {
        return $this->belongsTo(User::class);
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
    public function files(): HasMany{
        return $this->hasMany(File::class);
    }
}

