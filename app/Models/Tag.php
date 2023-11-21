<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
    ];



    public function belongs(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function isUsed():BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
