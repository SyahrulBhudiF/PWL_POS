<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $guarded = ['barang_id'];

    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        'image',
    ];

    /**
     * Eloquent accessor will changes value attribute if accessed, in
     * this case we change value image attribute to had full directory
     */
    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($image) => url('/storage/posts/' . $image)
        );
    }


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
