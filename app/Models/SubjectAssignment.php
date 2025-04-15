<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectAssignment extends Model
{
    protected $fillable = [
        'subject_id',
        'tutor_id',
        'assigned_by'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
