<?php

namespace App\Http\Controllers;

use App\Models\Merchant;

class MerchantController extends Controller
{
    public function index()
    {
        return view('stores.index', ['merchants' => Merchant::all()]);
    }

    public function show(int $id){

        $merchant = Merchant::find($id);

        if(!$merchant){
            return redirect()->route('merchants.index')->with('error',"Store doesn't exist");
        }


        return view('stores.show', ['merchant'=> $merchant, 'deals' => $merchant->deals()->get()]);
    }
}
