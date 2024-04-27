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
    
    public function predictRating($userRatings, $similarities, $wisataId)
    {
        $weightedSum = 0;
        $sumOfWeights = 0;

        // Iterasi melalui semua pengguna dan menghitung bobot total
        foreach ($similarities as $otherUserId => $similarity) {
            $otherUserRating = Rating::where('id_user', $otherUserId)
                ->where('id_wisata', $wisataId)
                ->first();

            if ($otherUserRating) {
                $otherUserRatings = $otherUserRating->toArray();

                foreach ($otherUserRatings as $category => $rating) {
                    if ($category != 'id_user' && $category != 'id_wisata') {
                        // Hitung jumlah bobot dan bobot terponderasi
                        $weightedSum += $similarity * ($rating - $userRatings[$otherUserId][$category]);
                        $sumOfWeights += abs($similarity);
                    }
                }
            }
        }

        // Menghindari pembagian dengan nol
        $sumOfWeights = max($sumOfWeights, 1e-9);
        
        // Menghitung prediksi rating dengan bobot terponderasi
        $prediction = $userRatings[auth()->id()][$category] + ($weightedSum / $sumOfWeights);

        return $prediction; // Kembalikan prediksi rating
    }
}
