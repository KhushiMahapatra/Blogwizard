<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentReply extends Model
{
    use HasFactory;

    // Fillable attributes for mass assignment
    protected $fillable = ['user_id', 'comment_id', 'comment', 'approved'];

    // Define a relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define a relationship to the Comment model
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Optionally, you can add a method to check if the reply is approved
    public function isApproved()
    {
        return $this->approved ?? false; // Assuming you have an 'approved' column
    }
}
