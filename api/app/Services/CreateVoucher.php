<?php


namespace App\Services;


use App\Models\Voucher;
use Carbon\Carbon;

class CreateVoucher
{
    /**
     * Create a voucher
     *
     * @param float $discount
     * @param string $expiryDate
     */
    public function create($discount, $expiryDate) {

        $order = new Voucher();
        $order->discount = $discount;
        $order->expiry_date = $expiryDate;

        do {
            $order->code = substr(md5(microtime()), 0, 6);
        } while (Voucher::where('code', $order->code)->where('expiry_date', '<', Carbon::now())->whereNull('order_id')->first());

        $order->save();
    }
}
