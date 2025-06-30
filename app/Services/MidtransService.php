<?php
namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class MidtransService
{
    public static function getSnapToken($orderId, $amount, $customerName, $customerEmail)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $customerEmail,
            ],
        ];
        return Snap::getSnapToken($params);
    }
}
