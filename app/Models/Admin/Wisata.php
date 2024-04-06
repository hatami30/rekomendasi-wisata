<?php

namespace App\Models\Admin;

use App\Models\User\Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori', 
        'nama_wisata', 
        'lokasi_wisata', 
        'latitude', 
        'longitude', 
        'desk_wisata', 
        'gambar_wisata'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * Get the ratings for the wisata.
     */
    public function rating()
    {
        return $this->hasMany(Rating::class, 'id_wisata');
    }
}
