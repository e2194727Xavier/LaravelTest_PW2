<?php

namespace App\Http\Controllers;

use App\Services\SAQService;
use Illuminate\Support\Facades\Log;

class SAQController extends Controller
{
    public function updateSAQ(SAQService $saqService)
    {
      
            // Call the getProduits function without specifying any parameters
            $results = $saqService->fetchProduit();
            return response()->json(['results' => $results]);
        
    }
}

