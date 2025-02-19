<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ModelTrait;
use App\Traits\Walletable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasRoles;
    use Walletable;
    use ModelTrait;

    protected $guarded = ['avatar'];
    protected $guard_name = 'web';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    # Getters

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile()
            ->useDisk(env('FILESYSTEM_DISK') ?? 'public');
    }
    public function isActive(): bool
    {
        return $this->is_active ?? 1;
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ($this->getFirstMediaUrl('avatar') != '' ? $this->getFirstMediaUrl('avatar') : asset('assets/avatar.png')),
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => (Hash::make($value)),
        );
    }


    # Relations
    public function deviceTokens(): MorphMany
    {
        return $this->morphMany(DeviceToken::class, 'tokenable');
    }
    public function latestOTPToken(): MorphOne
    {
        return $this->morphOne(AuthenticatableOtp::class, 'authenticatable')->latestOfMany();
    }

    public function OTPTokens(): MorphMany
    {
        return $this->morphMany(AuthenticatableOtp::class, 'authenticatable')->whereActive(true)->latest();
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function scopeFullName()
    {
        return $this->first_name . ' ' . $this->last_name;

    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }


    public function favoriteCourses(): MorphToMany
    {
        return $this->morphedByMany(Course::class, 'favoriteable', 'favorites')
            ->withTimestamps();
    }

    public function favoriteBooks(): MorphToMany
    {
        return $this->morphedByMany(Book::class, 'favoriteable', 'favorites')
            ->withTimestamps();
    }
    public function fatwaQuestions()
    {
        return $this->hasMany(FatwaQuestion::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);

    }

}
