<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;

use App\Models\ContentBlock;

class ContentController extends Controller
{
    // Retrieve content for the hero section
    public function hero()
    {
        $content = ContentBlock::where('section', 'hero')->first();
        return response()->json($content);
    }

    // Retrieve content for the about section
    public function about()
    {
        $content = ContentBlock::where('section', 'about')->first();
        return response()->json($content);
    }

    // Retrieve content for the consultation section
    public function consultation()
    {
        $content = ContentBlock::where('section', 'consultation')->first();
        return response()->json($content);
    }
     public function logo()
    {
        $content = ContentBlock::where('section', 'logo')->first();
        return response()->json($content);
    }
}
