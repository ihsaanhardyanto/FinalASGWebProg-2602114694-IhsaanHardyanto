<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'price'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_avatars');
    }
}