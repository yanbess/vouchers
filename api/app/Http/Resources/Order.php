<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $voucher = $this->voucher;
        unset($voucher->order_id);

        return [
            'id' => $this->id,
            'amount' => $this->voucher ? $this->amount - $this->voucher->discount : $this->amount,
            'origin_amount' => $this->amount,
            'status' => $this->status,
            'payed_at' => $this->payed_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'voucher' => $voucher,
        ];
    }
}
