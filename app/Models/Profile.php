<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    //protection from mass assignment, needed when Fillable error shows up
    protected $guarded = [];

    public function profileImage()
    {
        // /storage/ here is actually means /storage/app/public
        return '/storage/'.(($this->image) ?: ('profile/WOqxfMg2TI4h5SuvzR7iiSC1wOguQl58TQlRIv84.png'));
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    public function user() // follows convention
    {
        return $this->belongsTo(User::class);
    }
}
