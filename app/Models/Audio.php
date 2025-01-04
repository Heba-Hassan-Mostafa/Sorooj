<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Audio extends Model implements HasMedia
{
    use HasFactory, ModelTrait, InteractsWithMedia;

    protected $fillable = ['name', 'youtube_link', 'audio_file', 'category_id', 'status', 'publish_date', 'brief_description',
    'order_position','view_count', 'download_count', 'keywords', 'description', 'audioable_id', 'audioable_type'];

    public $filters = ['name', 'category_id', 'publish_date'];

    public function scopeOfName($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    public function scopeOfCategory_id($query, $keyword)
    {
        return $query->where('category_id', $keyword);
    }

    public function scopeOfPublish_date($query, $keyword)
    {
        return $query->where('publish_date', $keyword);
    }

    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }

    public function scopeActiveCategory($query)
    {
        return  $query->whereHas('category', function($q){

            $q->whereStatus(1);
        });
    }

    public function scopePublish($query)
    {
        return  $query->where('publish_date','<=',Carbon::now()->toDateString());
    }

    #Relations

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function audioable()
    {
        return $this->morphTo();
    }

}
