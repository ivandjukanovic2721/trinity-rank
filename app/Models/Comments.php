<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;
use App\Models\Post;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'content', 'article_id', 'type', 'parent_id', 'approved', 'user_id'];

    public function posts()
    {
    	return $this->belongsTo(Post::class, 'article_id');
    }

    public function news()
    {
    	return $this->belongsTo(News::class, 'article_id');
    }

    public function parent(){
    	return $this->belongsTo(Comments::class, 'parent_id');
    }
}
