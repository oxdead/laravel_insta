<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Telling to Laravel, it's ok to not protect anything, 
    //otherwise exception will apper (add caption to fillable), when we try to create a post
    //or we can actually add it into fillable array
    protected $guarded = []; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
