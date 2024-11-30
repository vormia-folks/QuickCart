<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    protected $fillable = ['flag'];

    /**
     * Todo: Table Name
     */
    protected $table = 'shopping';

    /**
     * Todo: Shopper ID / Token
     */
    public static function get_shopper_id($shopperToken = null)
    {
        // Check Shopping Token/Id
        $shopperToken = (is_null($shopperToken)) ? session('shopper') : $shopperToken;

        // Check $shopperToken
        if (is_null($shopperToken) || empty($shopperToken)) {
            $shopperToken = Str::random(50);
            session(['shopper' => $shopperToken]);
            session(['shopper_expiry' => now()->addMinutes(20)]);
        }

        // Check The Shopping
        $shoppingId = self::where('shooperid', $shopperToken)->where('created_at', '<', now()->subHour())->first()?->id;
        if (is_null($shoppingId)) {
            $_shopper = new self();
            $_shopper->shooperid = $shopperToken;
            $_shopper->flag = 1;
            $_shopper->save();

            // Call method
            return $_shopper->id;
        }

        // Return
        return $shoppingId;
    }
}
