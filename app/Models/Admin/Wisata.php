<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    protected $fillable = ['id_kategori', 'nama_wisata', 'lokasi_wisata', 'desk_wisata', 'gambar_wisata'];
}
