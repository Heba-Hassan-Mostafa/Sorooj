<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model implements HasMedia
{
    use HasFactory, ModelTrait,InteractsWithMedia;

    protected $fillable = ['name', 'youtube_link', 'video_file', 'category_id', 'status', 'publish_date', 'order_position',
                            'view_count', 'download_count', 'keywords', 'description', 'videoable_id', 'videoable_type'];

    public $filters = ['name', 'category_id', 'publish_date'];

    protected $definedRelations = ['category'];


    #Scopes
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

    public function videoable()
    {
        return $this->morphTo();
    }

}
