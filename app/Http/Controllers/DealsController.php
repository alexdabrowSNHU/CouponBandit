<?php

namespace App\Http\Controllers;
use App\Models\Deal;


class DealsController extends Controller {

    public function index(){
        $deals = Deal::all();

        return view('deals.index', ['deals' => $deals] );
    }

};