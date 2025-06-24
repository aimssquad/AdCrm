<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['filename', 'filepath', 'filetype'];

    protected $appends = ['url'];
    public function fileable()
    {
        return $this->morphTo();
    }
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}

