<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperBarang
 */
class Barang extends Model
{
    use HasFactory;

    protected $table = 'm_barang';

    protected $primaryKey = 'barang_id';

    protected $guarded = 'barang_id';

    function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'kategori_id');
    }

    function stok(): HasMany
    {
        return $this->hasMany(Stok::class, 'barang_id', 'barang_id');
    }

    function penjualanDetail(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'barang_id', 'barang_id');
    }
}
