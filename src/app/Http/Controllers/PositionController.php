<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __invoke()
    {
        $positions = Position::all();
        return response()->json([
            'success' => true,
            'positions' => $positions
        ]);
    }
}
