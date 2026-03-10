<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller

{

    public function toggleFavorite(int $deal_id){

        $user = Auth::user();
        $user->favoritedDeals()->toggle($deal_id);

        return back();
    }
}