<?php

namespace App\Models\User;

use App\Models\Admin\Wisata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Similarity extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id_wisata1',
        'id_wisata2', 
        'similarity'
    ];

    public function wisata1()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata1');
    }

    public function wisata2()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata2');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($similarity) {
            if ($similarity->similarity < 0 || $similarity->similarity > 1) {
                throw new \Exception("Similarity value must be between 0 and 1.");
            }
        });
    }
}
