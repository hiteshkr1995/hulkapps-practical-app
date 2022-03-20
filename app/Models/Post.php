<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasFactory, HasTags;

   public function author()
   {
      return $this->belongsTo(User::class, 'user_id', 'id');
   }

   public function comments()
   {
      return $this->hasMany(Comment::class);
   }
}
