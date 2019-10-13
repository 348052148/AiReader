<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(title="阅读商城API接口", version="0.1.9")
 */

/**
 * @OA\Server(url="http://127.0.0.1:8000/api/")
 */

class SwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/resource.json",
     *     @OA\Response(response="200", description="An example resource")
     * )
     */
    public function getJSON()
    {
        $swagger = \Openapi\scan(app_path('Http/Controllers/'));
        return response()->json($swagger, 200);
    }

    public function apidoc()
    {
        return view("swagger.index");
    }
}
