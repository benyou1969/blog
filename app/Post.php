<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/p/{$this->community->slug}/{$this->id}";
    }
    public function community()
    {
        return $this->belongsTo(Community::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($comment)
    {
        $this->comment()->create($comment);
    }

}
