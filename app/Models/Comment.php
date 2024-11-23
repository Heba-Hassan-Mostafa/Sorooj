<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory ,ModelTrait;

    protected $fillable = ['user_id', 'name', 'comment', 'stars','status', 'commentable_id', 'commentable_type'];


}
