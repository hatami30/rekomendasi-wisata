<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function calculateAverageRating()
    {
        $criteria = $this->getCriteriaNames();
        $totalRating = 0;
        $numCriteria = 0;

        foreach ($criteria as $criterion) {
            if ($this->attributes[$criterion]) {
                $totalRating += $this->attributes[$criterion];
                $numCriteria++;
            }
        }

        return ($numCriteria > 0) ? $totalRating / $numCriteria : 0;
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
        return array_diff($this->fillable, ['id_user', 'id_wisata']);
    }
}
