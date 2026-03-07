<?php

namespace App\Models;

use App\Enums\MerchantCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'logo_url',
        'brand_color',
        'website_url',
        'category',
    ];

    protected $casts = [
        'category' => MerchantCategory::class,
    ];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    // Constructs URL to find images
    protected function logoUrl(): Attribute {
        return Attribute::make(
            get: fn($value) => $value ? "/storage/merchant_logos/{$value}": null,
        );
    }
}