<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Gallery extends Model
{
    use HasFactory;

    public $uploadDirectory = '/storage/auth/posts/';

    public const POST_IMAGE = 1;

    protected $fillable = ['image','type','user_id'];

     public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => $this->uploadDirectory. $image

        );
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
