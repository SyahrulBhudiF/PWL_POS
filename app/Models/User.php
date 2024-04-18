<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperUser
 */
class User extends Model
{
    use HasFactory;

    protected $table = 'm_user';
    public $timestamps = false;
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'level_id', 'username', 'nama', 'password'];

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
}
