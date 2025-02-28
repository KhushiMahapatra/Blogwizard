<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
                'unique' => true,   // Ensure slugs are unique
                'separator' => '-',
            ]
        ];
    }


    public const PUBLISHED = 1;
    public const DRAFT = 0;


    protected $fillable = ['user_id', 'category_id', 'title', 'slug','description', 'status','gallery_id','category_post','excerpt','published_at','disable_comments'];


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function gallery(){
        return $this->belongsTo(Gallery::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function posts()
{
    return $this->belongsToMany(Post::class);
}
public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
