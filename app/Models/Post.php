<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'content',
        'author',
        'project_id',
        'submit_date',
        'last_edited',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function body(): string {
        return $this->content;
    }

    public function submit_date() :string {
        return $this->submit_date;
    }

    public function last_edited() :string {
        return $this->last_edited;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
