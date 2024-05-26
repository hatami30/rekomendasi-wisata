<?php

namespace App\Models\User;

use App\Models\User;
// use App\Models\User\Rating;
use App\Models\Admin\Wisata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prediction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_wisata',
        'predicted'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata');
    }
}
