<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FatwaQuestion extends Model
{
    use HasFactory,ModelTrait;

    protected $fillable = ['user_id', 'name', 'message', 'status'];

    #Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
