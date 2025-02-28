<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageComment extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'user_id', 'comment', 'approved','parent_id'];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id'); // Reference the correct foreign key
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(PageComment::class, 'parent_id');
    }

    // Define relationship for parent comment
    public function parent()
    {
        return $this->belongsTo(PageComment::class, 'parent_id');
    }
}

