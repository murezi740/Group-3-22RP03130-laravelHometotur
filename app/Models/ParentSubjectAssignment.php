<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Subject;
use App\Models\User;

class ParentSubjectAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'parent_id',
        'assigned_by'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
