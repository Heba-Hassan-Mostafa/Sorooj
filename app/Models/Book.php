<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model implements HasMedia
{
    use HasFactory,ModelTrait,InteractsWithMedia,Sluggable;

    protected $fillable = ['book_name','slug', 'book_content', 'brief_description','author_name', 'category_id', 'publish_date',
        'status', 'view_count', 'download_count', 'order_position', 'keywords', 'description'];

    public $filters = ['book_name', 'author_name', 'category_id', 'publish_date'];

    protected $definedRelations = ['category','media','favorites'];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'book_name',
                'onUpdate' => true,
            ]
        ];
    }

    public function registerMediaCollections(): void
    {
        // Handle single course image
        $this
            ->addMediaCollection('image')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK') ?? 'public');

        // Handle multiple PDF attachments
        $this
            ->addMediaCollection('attachments')
            ->useDisk(env('FILESYSTEM_DISK') ?? 'public')
            ->acceptsFile(function ($file) {
                return $file->mimeType === 'application/pdf';
            });
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->getFirstMediaUrl('image') != ''
                ? $this->getFirstMediaUrl('image') : asset('assets/admin/images/books.webp')),
        );
    }

    public function getAttachments()
    {
        return $this->getMedia('attachments');
    }

    public function scopeOfBook_name($query, $keyword)
    {
        return $query->where('book_name', 'like', '%' . $keyword . '%');
    }

    public function scopeOfAuthor_name($query, $keyword)
    {
        return $query->where('author_name', 'like', '%' . $keyword . '%');
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

    public function comments() : MorphMany
    {
        return $this->morphMany(Comment::class , 'commentable');
    }

    public function favoritedBy()
    {
        return $this->morphToMany(User::class, 'favoriteable', 'favorites');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function status()
    {
        return $this->status == 1 ? __('Active') : __('Inactive');
    }

}
