<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ManagementMember extends Model implements HasMedia
{
    use HasFactory , ModelTrait, InteractsWithMedia;

    protected $fillable = ['name', 'position', 'is_active', 'order_position'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK') ?? 'public');
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->getFirstMediaUrl('avatar') != '' ? $this->getFirstMediaUrl('avatar') : asset('assets/avatar.png')),
        );
    }
}
