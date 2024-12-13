<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, ModelTrait,Sluggable;
    protected $fillable = [
        'name',
        'slug',
        'type',
        'status',
        'order_position',
        'parent_id',

    ];

    public $filters = ['name','status','type'];

    protected $definedRelations = ['parent','subcategory','appearedSubcategory'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }
    #Scopes
    public function scopeOfName($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    public function scopeOfStatus($query, $keyword)
    {
        return $query->where('status',  $keyword);
    }
    public function scopeOfType($query, $keyword)
    {
        return $query->where('type',  $keyword);
    }

    public function scopeActive($query)
    {
        return  $query->whereStatus(1);
    }

    #Relations
    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }


    public function subcategory()
    {
        return $this->hasMany(Category::class,'parent_id');
    }

    public function appearedSubcategory()
    {
        return $this->hasMany(Category::class , 'parent_id' ,'id')->where('status',true);
    }

    public static function tree($level = 20)
    {
        return static::with(implode('.',array_fill(0, $level , 'subcategory')))
//            ->with('articles',function($q){
//                $q->whereStatus(1)->count();
//            })
            ->whereNull('parent_id')
            ->whereStatus(true)
            ->orderBy('order_position','asc')
            ->get();

    }

    public function courses()
    {
        return $this->hasMany(Course::class);

    }
    public function books()
    {
        return $this->hasMany(Book::class);

    }
    public function status()
    {
        return $this->status == 1 ? __('Active') : __('Inactive');
    }

}
