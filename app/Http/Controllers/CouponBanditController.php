<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;

class CouponBanditController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $dealsQuery = Deal::query()
            ->with('merchant')
            ->where('is_active', true);

        if ($search !== '') {
            $words = array_values(array_filter(preg_split('/\s+/', $search)));

            foreach ($words as $word) {
                $dealsQuery->where(function ($query) use ($word) {
                    $query->where('title', 'ilike', "%{$word}%")
                        ->orWhere('description', 'ilike', "%{$word}%")
                        ->orWhere('merchant_name', 'ilike', "%{$word}%")
                        ->orWhere('coupon_code', 'ilike', "%{$word}%")
                        ->orWhereHas('merchant', function ($merchantQuery) use ($word) {
                            $merchantQuery->where('name', 'ilike', "%{$word}%")
                                ->orWhere('category', 'ilike', "%{$word}%")
                                ->orWhere('description', 'ilike', "%{$word}%");
                        });
                });
            }
        }

        $deals = $dealsQuery
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->limit(12)
            ->get();

        return view('home', [
            'deals' => $deals,
            'search' => $search,
        ]);
    }
}
