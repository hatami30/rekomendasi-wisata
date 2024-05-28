<?php

namespace App\Http\Controllers\Admin;

use Laracsv\Export;
use Illuminate\Http\Request;
use App\Models\User\Prediction;
use App\Models\User\Similarity;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function exportSimilarityCSV()
    {
        $similarities = Similarity::all();
        $csvExporter = new Export();

        $csvExporter->build($similarities, ['id', 'id_wisata1', 'id_wisata2', 'similarity'])->download();
    }

    public function exportPredictionCSV()
    {
        $predictions = Prediction::all();
        $csvExporter = new Export();

        $csvExporter->build($predictions, ['id', 'id_user', 'id_wisata', 'predicted'])->download();
    }
}
