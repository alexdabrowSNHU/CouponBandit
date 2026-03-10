<?php

namespace App\Http\Controllers;

use App\Enums\MerchantCategory;
use App\Models\Merchant;

class CategoriesController extends Controller {

    public function index(){
        $merchants = Merchant::query()
            ->withCount([
                'deals as active_deals_count' => fn($query) => $query->where('is_active', true),
            ])
            ->orderBy('name')
            ->get();

        $groupedByCategory = $merchants->groupBy(function (Merchant $merchant) {
            return $merchant->category?->value ?? (string) $merchant->category;
        });

        $categories = collect(MerchantCategory::cases())->map(function (MerchantCategory $category) use ($groupedByCategory) {
            $categoryMerchants = $groupedByCategory->get($category->value, collect());

            return [
                'name' => $category->value,
                'merchant_count' => $categoryMerchants->count(),
                'active_deal_count' => $categoryMerchants->sum('active_deals_count'),
                'merchants' => $categoryMerchants,
            ];
        });

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

};