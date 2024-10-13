<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1);
        $ads = Ad::paginate($perPage);
        return response()->json($ads);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        return response()->json($ad, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        $ad->delete();
        return response()->json(null, 204);
    }
}
