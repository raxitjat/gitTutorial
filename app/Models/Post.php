<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $guarded = [];
    protected $appends = [];
    
    public function getImagePathAttribute($value)
    {
        // dd($value);
        if ($value) {
            if (!Storage::disk('public')->exists(config('custom.paths.postImage') . $value)) {
                return "";
            } else {
                return (Storage::url("public/post/images/" . $value));
            }
        } else {
            return "";
        }
    }
}

