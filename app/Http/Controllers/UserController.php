<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 1);
        $users = User::paginate($perPage);
        return response()->json($users);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        return response()->json($user, 201);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }

    public function storeCampaign(CampaignRequest $request, User $user)
    {
        $validated = $request->validated();
        $campaign = $user->campaigns()->create($validated);
        return response()->json($campaign, 201);
    }

    public function campaigns(Request $request, User $user)
    {
        $perPage = $request->input('per_page', 10);
        $campaigns = $user->campaigns()->paginate($perPage);
        return response()->json($campaigns);
    }
}
