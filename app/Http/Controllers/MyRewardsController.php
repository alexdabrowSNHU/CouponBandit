<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class MyRewardsController extends Controller {

    // Method to display My Rewards page from main navbar
    public function index(){

        return view('my_rewards.index', ['favorites' => Auth::user()->favoritedDeals]);

    }

};