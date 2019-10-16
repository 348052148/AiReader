<?php

namespace App\Http\Controllers\Admin;

use App\Classify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassifyController extends Controller
{
    public function classifyList(Request $request, $page)
    {
        $classifys = Classify::paginate(20, ['*'], 'page', $page);

        return response()->json($classifys);
    }
}
