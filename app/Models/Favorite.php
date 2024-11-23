<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory,ModelTrait;

    protected $fillable = ['user_id', 'favoriteable_id', 'favoriteable_type'];
}
