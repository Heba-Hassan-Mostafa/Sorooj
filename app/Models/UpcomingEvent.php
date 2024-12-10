<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class UpcomingEvent extends Model implements HasMedia
{
    use HasFactory , ModelTrait, InteractsWithMedia;

    protected $fillable = ['title', 'description', 'end', 'is_active'];

    protected $filters = ['end'];

    protected $casts = [
        'end' => 'datetime',
    ];

    protected function image(): Attribute
    {
    return Attribute::make(
        get: fn ($value) => ($this->getFirstMediaUrl('image') != ''
            ? $this->getFirstMediaUrl('image') : asset('assets/admin/images/events.webp')),
    );
    }

    public function scopeOfEnd($query , $keyword = true)
    {
        if ($keyword){
            return $query->where('end', '>', Carbon::now());

        }
        return $query;
    }
}
