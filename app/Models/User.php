<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as UserAuthenticate;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @mixin IdeHelperUser
 */
class User extends UserAuthenticate implements JWTSubject
{
    use HasFactory;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    protected $table = 'm_user';
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'image'];

    function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'level_id');
    }

    function stok(): HasMany
    {
        return $this->hasMany(Stok::class, 'user_id', 'user_id');
    }

    function penjualan(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'user_id');
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => url('/storage/posts/' . $image)
        );
    }
}
