<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperKategori
 */
class Kategori extends Model
{
    protected $table = "m_kategori";
    protected $primaryKey = "kategori_id";

    protected $fillable = ['kategori_kode', 'kategori_nama'];

    function barang() : HasMany {
        return $this->hasMany(Barang::class, 'barang_id', 'barang_id');
    }
}
