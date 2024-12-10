<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FatwaQuestion extends Model
{
    use HasFactory,ModelTrait ,Sluggable;

    protected $fillable = ['user_id', 'name', 'message','slug', 'status'];

    public $filters = ['publish_date','answerContent'];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'message',
                'onUpdate' => true,
            ]
        ];
    }
    #Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fatwaAnswer()
    {
        return $this->hasOne(FatwaAnswer::class,'fatwa_question_id');
    }

    #Scopes
    public function scopePublish_date($query,$keyword)
    {
        return $query->where('publish_date',$keyword);


    }


    public function scopeOfAnswerContent($query, $keyword = true)
    {
        if ($keyword) {
            $query->with(['fatwaAnswer' => function ($query) {
                $query->select('fatwa_question_id', 'answer_content');
            }]);
        }

        return $query;
    }


    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }
}
