<?php

namespace App\Models\User;

use App\Models\User;
use App\Models\Admin\Wisata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_wisata',
        'harga',
        'fasilitas',
        'keamanan',
        'kenyamanan',
        'kebersihan',
        'keindahan',
        'pelayanan',
        'average',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function wisata()
    {
        return $this->belongsTo(Wisata::class, 'id_wisata');
    }

    public function setData($data)
    {
        $this->id_wisata = $data['id_wisata'];
        $this->harga = $data['harga'];
        $this->fasilitas = $data['fasilitas'];
        $this->keamanan = $data['keamanan'];
        $this->kenyamanan = $data['kenyamanan'];
        $this->kebersihan = $data['kebersihan'];
        $this->keindahan = $data['keindahan'];
        $this->pelayanan = $data['pelayanan'];
    }

    public function calculateAverageRating()
    {
        $criteria = $this->getCriteriaNames();
        $totalRating = 0;
        $numCriteria = 0;

        foreach ($criteria as $criterion) {
            if (!empty($this->{$criterion})) {
                $totalRating += $this->{$criterion};
                $numCriteria++;
            }
        }

        $average = ($numCriteria > 0) ? $totalRating / $numCriteria : null;

        return $average;
    }

    public function setCriteriaRatings($ratings)
    {
        $criteria = $this->getCriteriaNames();

        foreach ($criteria as $criterion) {
            if (isset($ratings[$criterion])) {
                $this->{$criterion} = $ratings[$criterion];
            }
        }

        $this->save();
    }

    public function getCriteriaNames()
    {
        return array_diff($this->fillable, [
            'id_user', 
            'id_wisata', 
            'average'
        ]);
    }
}
