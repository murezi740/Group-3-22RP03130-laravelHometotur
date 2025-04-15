<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    ];

    /**
     * Get the subjects assigned to the user.
     */
    public function assignedSubjects()
    {
        return $this->hasMany(ParentSubjectAssignment::class, 'parent_id');
    }

    /**
     * Get the subjects assigned by the user.
     */
    public function assignedByMe()
    {
        return $this->hasMany(Assignment::class, 'assigned_by');
    }

    /**
     * Get the contents created by the user.
     */
    public function contents()
    {
        return $this->hasMany(Content::class, 'tutor_id');
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a tutor.
     *
     * @return bool
     */
    public function isTutor()
    {
        return $this->role === 'tutor';
    }

    /**
     * Check if the user is a parent.
     *
     * @return bool
     */
    public function isParent()
    {
        return $this->role === 'parent';
    }
}
