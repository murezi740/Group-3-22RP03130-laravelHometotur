<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'subject_id',
        'title',
        'body'
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function files()
    {
        return $this->hasMany(ContentFile::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
