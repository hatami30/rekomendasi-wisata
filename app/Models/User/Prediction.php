<?php

namespace App\Models\User;

use App\Models\User;
use App\Models\User\Rating;
use App\Models\Admin\Wisata;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prediction extends Model
{
    use HasFactory;

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
    
    public function predictRating($userRatings, $similarities, $userId, $wisataId)
    {
        $weightedSum = 0;
        $sumOfWeights = 0;

        foreach ($userRatings as $otherWisataId => $rating) {
            if ($otherWisataId != $wisataId && isset($similarities[$otherWisataId][$wisataId])) {
                $weightedSum += $rating * $similarities[$otherWisataId][$wisataId];
                $sumOfWeights += $similarities[$otherWisataId][$wisataId];
            }
        }

        if ($sumOfWeights != 0) {
            return $weightedSum / $sumOfWeights;
        } else {
            return 0;
        }
    }

    // private function calculateAverageUserRating($userId)
    // {
    //     $userRatings = Rating::where('id_user', $userId)->get();

    //     $totalRating = 0;
    //     foreach ($userRatings as $rating) {
    //         $totalRating += $rating->average; 
    //     }

    //     $numRatings = count($userRatings);

    //     $averageRating = $numRatings > 0 ? $totalRating / $numRatings : 0;

    //     return $averageRating;
    // }
}
