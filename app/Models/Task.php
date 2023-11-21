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
        'description',
        'deadline',
    ];



    public function assigned(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
