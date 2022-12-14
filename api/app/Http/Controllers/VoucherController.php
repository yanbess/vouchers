<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Services\CreateVoucher;
use App\Services\UpdateVoucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    /**
     * Create a new voucher
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'discount' => 'required|numeric|max:100000',
            'expiry_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $this->setValidationErrors($validator->errors()->toArray());
            return $this->getResponse();
        }

        $createVoucher = new CreateVoucher;
        $createVoucher->create($request->discount, $request->expiry_date);

        return $this->getResponse();
    }

    /**
     * Update a voucher
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'discount' => 'required|numeric|max:100000',
            'expiry_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            $this->setValidationErrors($validator->errors()->toArray());
            return $this->getResponse();
        }

        $updateOrder = new UpdateVoucher;
        $updateOrder->update($request->id, $request->discount, $request->expiry_date);

        if ($updateOrder->getError()) {
            $this->setErrorMessage(__($updateOrder->getError()));
            return $this->getResponse();
        }

        return $this->getResponse();
    }

    /**
     * Delete a voucher
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $this->setValidationErrors($validator->errors()->toArray());
            return $this->getResponse();
        }

        $voucher = Voucher::find($request->id);
        $voucher->delete();

        return $this->getResponse();
    }

    /**
     * Get the list active (active voucher - not used and not expired) or expired vouchers
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $vouchers = Voucher::whereNull('order_id')
            ->where('expiry_date', $request->is_expired ? '<=' : '>', Carbon::now())
            ->orderBy('updated_at', 'asc')
            ->paginate(5);

        $this->setResponseData($vouchers);

        return $this->getResponse();
    }
}
