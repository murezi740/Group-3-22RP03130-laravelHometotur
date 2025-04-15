<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assignment;
use App\Models\Content;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
