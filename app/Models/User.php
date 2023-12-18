<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\FileController;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;


// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'projects',
        'file'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];


    public function projects_for_user(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
    }
    public function tasks(): BelongsToMany{
        return $this->belongsToMany(Task::class, 'task_user', 'user_id', 'task_id')->with('project'); 

    }
    protected $attributes = [
        'is_admin' => false,
    ];

    public function projects(): BelongsToMany {
        return $this->belongsToMany(Project::class);
    }

    public function assign(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public function coordinates(): HasMany
    {
        return $this->hasMany(Project::class);
    }


    public function tasks_created(): HasMany
    {
        return $this->hasMany(Task::class, 'opened_user_id',);
    }
    public function getProfileImage() {
        return FileController::get('user', $this->id);
    }
    

    public function openedTasks(): HasMany {
        return $this->hasMany(Task::class, 'opened_user_id');

    }

    public function closedTasks(): HasMany {
        return $this->hasMany(Task::class, 'closed_user_id');

    }
}
 

