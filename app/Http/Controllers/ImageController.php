<?php

namespace App\Http\Controllers;

use App\Http\Service\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function image(Request $request, ImageService $imageService)
    {
        return response()->stream(function () use ($imageService, $request) {
            echo $imageService->getImage($request->input('url'));
        }, 200, ['Content-Type' => 'image/jpeg']);
    }
}
