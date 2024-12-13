<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use HasFactory ,ModelTrait,InteractsWithMedia;

    protected $fillable = ['title', 'link', 'status', 'order_position'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->getFirstMediaUrl('image') != ''
                ? $this->getFirstMediaUrl('image') : asset('assets/admin/images/default_slider.webp')),
        );
    }

    public function status()
    {
        return $this->status == 1 ? __('Active') : __('Inactive');
    }
}
