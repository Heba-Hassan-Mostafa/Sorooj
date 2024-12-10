<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FatwaAnswer extends Model
{
    use HasFactory ,ModelTrait;

    protected $fillable = ['fatwa_question_id', 'answer_content', 'audio_file', 'youtube_link', 'publish_date'];

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
