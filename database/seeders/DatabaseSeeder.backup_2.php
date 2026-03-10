<?php

namespace Database\Seeders;

use App\Enums\DealType;
use App\Models\Deal;
use App\Models\User;
use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        // Seed merchants
        $merchants = [
            [
                'name' => 'Amazon',
                'description' => 'Online marketplace with deals across every category.',
                'website_url' => 'https://www.amazon.com',
                'category' => 'Home',
                'logo_url' => 'amazon.png',
                'brand_color' => '#FF9900',
            ],
            [
                'name' => 'Nike',
                'description' => 'Athletic shoes and sportswear.',
                'website_url' => 'https://www.nike.com',
                'category' => 'Clothing',
                'logo_url' => 'nike.png',
                'brand_color' => '#111111',
            ],
            [
                'name' => 'Apple',
                'description' => 'Premium electronics and tech products.',
                'website_url' => 'https://www.apple.com',
                'category' => 'Electronics',
                'logo_url' => 'apple.png',
                'brand_color' => '#555555',
            ],
            [
                'name' => 'Target',
                'description' => 'General merchandise and everyday essentials.',
                'website_url' => 'https://www.target.com',
                'category' => 'Retail',
                'logo_url' => 'target.png',
                'brand_color' => '#CC0000',
            ],
            [
                'name' => 'Best Buy',
                'description' => 'Electronics and technology retailer.',
                'website_url' => 'https://www.bestbuy.com',
                'category' => 'Electronics',
                'logo_url' => 'bestbuy.png',
                'brand_color' => '#0046BE',
            ],
            [
                'name' => 'Adidas',
                'description' => 'Sports footwear and athletic apparel.',
                'website_url' => 'https://www.adidas.com',
                'category' => 'Clothing',
                'logo_url' => 'adidas.png',
                'brand_color' => '#000000',
            ],
            [
                'name' => 'Sephora',
                'description' => 'Beauty and cosmetics products.',
                'website_url' => 'https://www.sephora.com',
                'category' => 'Beauty',
                'logo_url' => 'sephora.png',
                'brand_color' => '#000000',
            ],
            [
                'name' => 'Chewy',
                'description' => 'Pet food, toys, and supplies with fast shipping.',
                'website_url' => 'https://www.chewy.com',
                'category' => 'Pets',
                'logo_url' => 'chewy.png',
                'brand_color' => '#1C49C2',
            ],
            [
                'name' => 'Petco',
                'description' => 'Pet wellness, food, and accessories.',
                'website_url' => 'https://www.petco.com',
                'category' => 'Pets',
                'logo_url' => 'petco.png',
                'brand_color' => '#0056A3',
            ],
            [
                'name' => 'Expedia',
                'description' => 'Travel booking for flights, hotels, and packages.',
                'website_url' => 'https://www.expedia.com',
                'category' => 'Travel',
                'logo_url' => 'expedia.png',
                'brand_color' => '#00355F',
            ],
            [
                'name' => 'Southwest Airlines',
                'description' => 'Airline deals and flexible flight options.',
                'website_url' => 'https://www.southwest.com',
                'category' => 'Travel',
                'logo_url' => 'southwest airlines.png',
                'brand_color' => '#304CB2',
            ],
            [
                'name' => 'Ulta Beauty',
                'description' => 'Beauty essentials, skincare, and salon products.',
                'website_url' => 'https://www.ulta.com',
                'category' => 'Beauty',
                'logo_url' => 'ulta beauty.png',
                'brand_color' => '#E55C20',
            ],
            [
                'name' => 'Wayfair',
                'description' => 'Home furnishings and decor for every style.',
                'website_url' => 'https://www.wayfair.com',
                'category' => 'Home',
                'logo_url' => 'wayfair.png',
                'brand_color' => '#7B2D8E',
            ],
            [
                'name' => 'Macy\'s',
                'description' => 'Department store with apparel and home brands.',
                'website_url' => 'https://www.macys.com',
                'category' => 'Retail',
                'logo_url' => "macy's.png",
                'brand_color' => '#E21A2C',
            ],
            [
                'name' => 'Newegg',
                'description' => 'Tech marketplace for components and gadgets.',
                'website_url' => 'https://www.newegg.com',
                'category' => 'Electronics',
                'logo_url' => 'newegg.png',
                'brand_color' => '#F68B1E',
            ],
        ];

        foreach ($merchants as $merchant) {
            $merchant['description'] = $this->formatSeedDescription($merchant['description']);

            Merchant::updateOrCreate(
                ['name' => $merchant['name']],
                $merchant
            );
        }

        $merchantByName = Merchant::query()
            ->whereIn('name', array_column($merchants, 'name'))
            ->get()
            ->keyBy('name');

        $deals = [
            ['merchant_name' => 'Amazon', 'type' => DealType::PERCENT_OFF->value, 'title' => '20% Off Select Home Essentials', 'description' => 'Save on eligible kitchen and home picks.', 'start_date' => '2026-03-01', 'end_date' => '2026-03-20', 'is_active' => true, 'deal_url' => 'https://www.amazon.com/deals', 'coupon_code' => 'HOME20', 'discount_value' => 20.00],
            ['merchant_name' => 'Amazon', 'type' => DealType::CASHBACK->value, 'title' => '8% Cashback on Tech Accessories', 'description' => 'Cashback on selected chargers and cables.', 'start_date' => '2026-03-02', 'end_date' => '2026-03-25', 'is_active' => true, 'deal_url' => 'https://www.amazon.com/tech', 'coupon_code' => null, 'discount_value' => 8.00],
            ['merchant_name' => 'Nike', 'type' => DealType::DOLLAR_OFF->value, 'title' => '$25 Off Running Shoes', 'description' => 'Discount applies to select performance models.', 'start_date' => '2026-03-03', 'end_date' => '2026-03-22', 'is_active' => true, 'deal_url' => 'https://www.nike.com/running', 'coupon_code' => 'RUN25', 'discount_value' => 25.00],
            ['merchant_name' => 'Nike', 'type' => DealType::BOGO->value, 'title' => 'Buy 1 Get 1 50% Off Socks', 'description' => 'Mix and match eligible sock styles.', 'start_date' => '2026-03-01', 'end_date' => '2026-03-18', 'is_active' => true, 'deal_url' => 'https://www.nike.com/socks', 'coupon_code' => null, 'discount_value' => null, 'bogo_buy_quantity' => 1, 'bogo_get_quantity' => 1, 'bogo_product' => 'socks'],
            ['merchant_name' => 'Apple', 'type' => DealType::CASHBACK->value, 'title' => '5% Cashback on Accessories', 'description' => 'Cashback for cases, chargers, and peripherals.', 'start_date' => '2026-03-04', 'end_date' => '2026-03-24', 'is_active' => true, 'deal_url' => 'https://www.apple.com/shop/accessories', 'coupon_code' => null, 'discount_value' => 5.00],
            ['merchant_name' => 'Target', 'type' => DealType::PERCENT_OFF->value, 'title' => '15% Off Household Basics', 'description' => 'Save on cleaning and daily essentials.', 'start_date' => '2026-03-02', 'end_date' => '2026-03-17', 'is_active' => true, 'deal_url' => 'https://www.target.com/c/household-essentials', 'coupon_code' => 'SAVE15', 'discount_value' => 15.00],
            ['merchant_name' => 'Target', 'type' => DealType::DOLLAR_OFF->value, 'title' => '$10 Off Orders Over $60', 'description' => 'Minimum purchase required before tax.', 'start_date' => '2026-03-01', 'end_date' => '2026-03-21', 'is_active' => true, 'deal_url' => 'https://www.target.com', 'coupon_code' => 'TENOFF60', 'discount_value' => 10.00],
            ['merchant_name' => 'Best Buy', 'type' => DealType::PERCENT_OFF->value, 'title' => '18% Off Smart Home Devices', 'description' => 'Discount on select smart home products.', 'start_date' => '2026-03-03', 'end_date' => '2026-03-19', 'is_active' => true, 'deal_url' => 'https://www.bestbuy.com/site/smart-home', 'coupon_code' => null, 'discount_value' => 18.00],
            ['merchant_name' => 'Best Buy', 'type' => DealType::DOLLAR_OFF->value, 'title' => '$50 Off Laptops Over $700', 'description' => 'Limited-time laptop markdown.', 'start_date' => '2026-03-05', 'end_date' => '2026-03-26', 'is_active' => true, 'deal_url' => 'https://www.bestbuy.com/site/laptops', 'coupon_code' => 'LAPTOP50', 'discount_value' => 50.00],
            ['merchant_name' => 'Adidas', 'type' => DealType::PERCENT_OFF->value, 'title' => '30% Off Select Apparel', 'description' => 'Save on tees, hoodies, and joggers.', 'start_date' => '2026-03-02', 'end_date' => '2026-03-16', 'is_active' => true, 'deal_url' => 'https://www.adidas.com/us/apparel-sale', 'coupon_code' => 'APP30', 'discount_value' => 30.00],
            ['merchant_name' => 'Adidas', 'type' => DealType::BOGO->value, 'title' => 'Buy 2 Get 1 Free Tees', 'description' => 'Eligible on selected t-shirt collections.', 'start_date' => '2026-03-06', 'end_date' => '2026-03-23', 'is_active' => true, 'deal_url' => 'https://www.adidas.com/us/men-tshirts', 'coupon_code' => null, 'discount_value' => null, 'bogo_buy_quantity' => 2, 'bogo_get_quantity' => 1, 'bogo_product' => 't-shirts'],
            ['merchant_name' => 'Sephora', 'type' => DealType::PERCENT_OFF->value, 'title' => '20% Off Skincare Favorites', 'description' => 'Includes moisturizers and cleansers.', 'start_date' => '2026-03-01', 'end_date' => '2026-03-15', 'is_active' => true, 'deal_url' => 'https://www.sephora.com/shop/skincare', 'coupon_code' => 'GLOW20', 'discount_value' => 20.00],
            ['merchant_name' => 'Sephora', 'type' => DealType::CASHBACK->value, 'title' => '6% Cashback on Fragrance', 'description' => 'Cashback available on qualifying brands.', 'start_date' => '2026-03-04', 'end_date' => '2026-03-30', 'is_active' => true, 'deal_url' => 'https://www.sephora.com/shop/fragrance', 'coupon_code' => null, 'discount_value' => 6.00],
            ['merchant_name' => 'Chewy', 'type' => DealType::DOLLAR_OFF->value, 'title' => '$15 Off First AutoShip Order', 'description' => 'Applies to first autoship setup order.', 'start_date' => '2026-03-03', 'end_date' => '2026-03-27', 'is_active' => true, 'deal_url' => 'https://www.chewy.com/app/content/autoship', 'coupon_code' => 'AUTO15', 'discount_value' => 15.00],
            ['merchant_name' => 'Chewy', 'type' => DealType::BOGO->value, 'title' => 'Buy 1 Get 1 Free Dog Treats', 'description' => 'Selected brands and sizes only.', 'start_date' => '2026-03-02', 'end_date' => '2026-03-19', 'is_active' => true, 'deal_url' => 'https://www.chewy.com/b/dog-treats-316', 'coupon_code' => null, 'discount_value' => null, 'bogo_buy_quantity' => 1, 'bogo_get_quantity' => 1, 'bogo_product' => 'dog treats'],
            ['merchant_name' => 'Petco', 'type' => DealType::PERCENT_OFF->value, 'title' => '25% Off Cat Food Bundles', 'description' => 'Bundle savings on select dry and wet food.', 'start_date' => '2026-03-05', 'end_date' => '2026-03-22', 'is_active' => true, 'deal_url' => 'https://www.petco.com/shop/en/petcostore/cat/cat-food', 'coupon_code' => 'CAT25', 'discount_value' => 25.00],
            ['merchant_name' => 'Petco', 'type' => DealType::CASHBACK->value, 'title' => '7% Cashback on Aquarium Supplies', 'description' => 'Earn cashback on filtration and care items.', 'start_date' => '2026-03-06', 'end_date' => '2026-03-24', 'is_active' => true, 'deal_url' => 'https://www.petco.com/shop/en/petcostore/fish', 'coupon_code' => null, 'discount_value' => 7.00],
            ['merchant_name' => 'Expedia', 'type' => DealType::PERCENT_OFF->value, 'title' => '12% Off Hotel Stays', 'description' => 'Valid for participating hotels this month.', 'start_date' => '2026-03-01', 'end_date' => '2026-03-31', 'is_active' => true, 'deal_url' => 'https://www.expedia.com/deals', 'coupon_code' => 'HOTEL12', 'discount_value' => 12.00],
            ['merchant_name' => 'Expedia', 'type' => DealType::CASHBACK->value, 'title' => '4% Cashback on Vacation Packages', 'description' => 'Cashback available on package bookings.', 'start_date' => '2026-03-07', 'end_date' => '2026-03-28', 'is_active' => true, 'deal_url' => 'https://www.expedia.com/package-deals', 'coupon_code' => null, 'discount_value' => 4.00],
            ['merchant_name' => 'Southwest Airlines', 'type' => DealType::DOLLAR_OFF->value, 'title' => '$30 Off Roundtrip Flights', 'description' => 'Discount applies to eligible domestic routes.', 'start_date' => '2026-03-02', 'end_date' => '2026-03-20', 'is_active' => true, 'deal_url' => 'https://www.southwest.com/deals', 'coupon_code' => 'FLY30', 'discount_value' => 30.00],
            ['merchant_name' => 'Ulta Beauty', 'type' => DealType::PERCENT_OFF->value, 'title' => '15% Off Haircare Essentials', 'description' => 'Save on shampoo, conditioner, and styling.', 'start_date' => '2026-03-03', 'end_date' => '2026-03-21', 'is_active' => true, 'deal_url' => 'https://www.ulta.com/shop/hair', 'coupon_code' => 'HAIR15', 'discount_value' => 15.00],
            ['merchant_name' => 'Ulta Beauty', 'type' => DealType::BOGO->value, 'title' => 'Buy 2 Get 1 Free Makeup Minis', 'description' => 'Promotion on selected mini products.', 'start_date' => '2026-03-04', 'end_date' => '2026-03-18', 'is_active' => true, 'deal_url' => 'https://www.ulta.com/shop/makeup', 'coupon_code' => null, 'discount_value' => null, 'bogo_buy_quantity' => 2, 'bogo_get_quantity' => 1, 'bogo_product' => 'makeup minis'],
            ['merchant_name' => 'Wayfair', 'type' => DealType::PERCENT_OFF->value, 'title' => '22% Off Living Room Furniture', 'description' => 'Limited-time savings on featured collections.', 'start_date' => '2026-03-05', 'end_date' => '2026-03-26', 'is_active' => true, 'deal_url' => 'https://www.wayfair.com/furniture/cat/living-room-furniture-c45974.html', 'coupon_code' => 'LIVING22', 'discount_value' => 22.00],
            ['merchant_name' => 'Macy\'s', 'type' => DealType::DOLLAR_OFF->value, 'title' => '$20 Off Orders Over $100', 'description' => 'One-time use on qualifying full-price items.', 'start_date' => '2026-03-01', 'end_date' => '2026-03-25', 'is_active' => true, 'deal_url' => 'https://www.macys.com', 'coupon_code' => 'SAVE20', 'discount_value' => 20.00],
            ['merchant_name' => 'Newegg', 'type' => DealType::CASHBACK->value, 'title' => '5% Cashback on PC Components', 'description' => 'Earn cashback on selected components.', 'start_date' => '2026-03-06', 'end_date' => '2026-03-29', 'is_active' => true, 'deal_url' => 'https://www.newegg.com/Components/Store', 'coupon_code' => null, 'discount_value' => 5.00],
        ];

        foreach ($deals as $deal) {
            $merchant = $merchantByName->get($deal['merchant_name']);

            if (! $merchant) {
                continue;
            }

            $deal['description'] = $this->formatSeedDescription($deal['description']);

            Deal::updateOrCreate(
                [
                    'title' => $deal['title'],
                    'merchant_name' => $deal['merchant_name'],
                ],
                array_merge($deal, ['merchant_id' => $merchant->id])
            );
        }
    }

    private function formatSeedDescription(string $description): string
    {
        return str_replace(' And ', ' + ', Str::title($description));
    }
}
