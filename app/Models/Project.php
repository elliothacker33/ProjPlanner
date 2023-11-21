<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'user_id',
    ];

    protected $hidden = ['tsvectors'];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class);
    }

    public function coordinator() {
        return $this->belongsTo(User::class);
    }
}
