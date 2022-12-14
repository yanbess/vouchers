<?php


namespace App\Services;


use App\Models\Order;
use App\Models\Voucher;
use Carbon\Carbon;

class PurchaseOrder
{
    private $error;

    /**
     * Purchase order
     *
     * @param integer $orderId
     * @param string $voucherCode
     */
    public function purchase($orderId, $voucherCode = false) {

        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)->whereNull('order_id')->first();
            if (empty($voucher)) {
                $this->setError('The specified voucher was not found');
                return;
            } elseif (Carbon::parse($voucher->expiry_date)->lessThan('now')) {
                $this->setError('This voucher has expired');
                return;
            }
        }

        $order = Order::where([
            'id' => $orderId,
            'status' => Order::STATUS_NEW,
        ])->firstOrFail();
        $order->status = 'paid';
        $order->payed_at = Carbon::now();
        $order->save();

        if ($voucherCode) {
            $voucher->order_id = $orderId;
            $voucher->save();
        }
    }

    public function setError($message) {
        $this->error = $message;
    }

    public function getError() {
        return $this->error;
    }
}
