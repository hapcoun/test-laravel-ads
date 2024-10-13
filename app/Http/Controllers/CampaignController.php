<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1);
        $campaigns = Campaign::paginate($perPage);
        return response()->json($campaigns);
    }

    public function show(Campaign $campaign)
    {
        return response()->json($campaign, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampaignRequest $request)
    {
        $validated = $request->validated();
        $campaign = Campaign::create($validated);
        return response()->json($campaign, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->json(null, 204);
    }

    public function storeAd(AdRequest $request, Campaign $campaign)
    {
        $validated = $request->validated();
        $ad = $campaign->ads()->create($validated);
        return response()->json($ad, 201);
    }

    public function ads(Request $request, Campaign $campaign)
    {
        $perPage = $request->input('per_page', 10);
        $ads = $campaign->ads()->paginate($perPage);
        return response()->json($ads);
    }
}
