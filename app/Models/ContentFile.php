<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentFile extends Model
{
    protected $fillable = [
        'content_id',
        'filename',
        'original_filename',
        'mime_type',
        'size'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
