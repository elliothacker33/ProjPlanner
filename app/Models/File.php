<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'project_id',
    ];

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

}