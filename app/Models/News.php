<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comments;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'title', 'content'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany( Comments::class, 'article_id' )
                        ->where('type', 'news')
                        ->where('approved', 1)
                        ->where('parent_id', 0);
    }

    public function sub_comments()
    {
        return $this->hasMany( Comments::class, 'article_id' )
                        ->where('type', 'news')
                        ->where('approved', 1)
                        ->where('parent_id', '!=', 0);
    }
}
