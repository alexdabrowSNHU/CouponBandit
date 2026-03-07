<?php

namespace App\Models;

use App\Enums\DealType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        "type",
        "merchant_id",
        "merchant_name",
        "title",
        "description",
        "start_date",
        "end_date",
        "is_active",
        "deal_url",
        "coupon_code",
        "discount_value",
        "bogo_buy_quantity",
        "bogo_get_quantity",
        "bogo_product",
    ];

    protected $casts = [
        "type" => DealType::class,
        "merchant_name" => "string",
        "start_date" => "date",
        "end_date" => "date",
        "expires_at" => "datetime",
        "is_active" => "boolean",
        "discount_value" => "decimal:2",
        "bogo_buy_quantity" => "integer",
        "bogo_get_quantity" => "integer",
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    protected function endDate(): Attribute
{
    return Attribute::make(
        set: function ($value) {
            $expiresAt = Carbon::parse($value)
                ->setTime(3, 0)
                ->timezone('America/New_York');

            return [
                'end_date' => $value,
                'expires_at' => $expiresAt,
            ];
        },
    );
}


}