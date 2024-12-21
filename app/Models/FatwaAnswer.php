<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FatwaAnswer extends Model implements HasMedia
{
    use HasFactory ,ModelTrait,InteractsWithMedia;

    protected $fillable = ['fatwa_question_id', 'answer_content', 'youtube_link', 'publish_date'];

    public $filters = ['publish'];

    #Relations
    protected $definedRelations = ['fatwaQuestion'];
    public function fatwaQuestion()
    {
        return $this->belongsTo(FatwaQuestion::class);
    }


    #scopes

    public function scopePublished($query)
    {
        return  $query->where('publish_date','<=',Carbon::now()->toDateString());
    }

}
