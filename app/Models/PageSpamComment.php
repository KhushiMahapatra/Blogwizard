<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSpamComment extends Model
{
    use HasFactory;

    protected $table = 'page_spam_comments';

    protected $fillable = [
        'page_id',
        'user_id',
        'comment',
    ];

    // Relationship with the Page model
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
