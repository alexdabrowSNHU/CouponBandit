<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function toggleFavorite(Request $request, int $deal_id)
    {
        $user = Auth::user();
        $user->favoritedDeals()->toggle($deal_id);

        if ($request->ajax()) {
            return response()->json([
                'favorited' => $user->favoritedDeals()->where('deal_id', $deal_id)->exists(),
            ]);
        }

        return back();
    }
}