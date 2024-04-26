<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBukuModel extends Model
{
    use HasFactory;
    protected $table  = 'log_buku';
    protected $guarded = [];

    public function kategoriRela()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori', 'id');
    }
}
