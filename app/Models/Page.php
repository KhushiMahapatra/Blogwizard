<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    use HasFactory;

    
    protected $fillable = ['title','slug', 'description','comment','comments_enabled','published_at','status'];
    public function comments()
    {
        return $this->hasMany(PageComment::class, 'page_id'); // Relate comments using page_id
    }
    
    public function isPublished()
    {
        return $this->status === 'published' || ($this->status === 'scheduled' && $this->published_at <= Carbon::now());
    }
}

