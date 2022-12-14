<?php


namespace App\Services;


use App\Models\Voucher;
use Carbon\Carbon;

class UpdateVoucher
{
    private $error;

    /**
     * Update a voucher
     *
     * @param integer $voucherId
     * @param float $discount
     * @param string $expiryDate
     */
    public function update($voucherId, $discount, $expiryDate) {

        $voucher = Voucher::find($voucherId);

        if ($voucher->order_id) {
            $this->setError('You can\'t edit this voucher, because it has already used');
            return;
        } elseif (Carbon::parse($voucher->expiry_date)->lessThan('now')) {
            $this->setError('You can\'t edit this voucher, because it has expired');
            return;
        }

        $voucher->discount = $discount;
        $voucher->expiry_date = $expiryDate;
        $voucher->save();
    }

    public function setError($message) {
        $this->error = $message;
    }

    public function getError() {
        return $this->error;
    }
}
