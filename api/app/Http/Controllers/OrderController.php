<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\Voucher;
use App\Services\PurchaseOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Create a new order
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|max:100000',
        ]);

        if ($validator->fails()) {
            $this->setValidationErrors($validator->errors()->toArray());
            return $this->getResponse();
        }

        $order = new Order;
        $order->fill($request->all());
        $order->save();

        return $this->getResponse();
    }

    /**
     * Get a paginated list of orders sorted by purchased date
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $query = Order::with(['voucher']);

        if ($request->purchased_only) {
            $query->whereNotNull('purchased_at')
                ->orderBy('purchased_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $this->setResponseData(new OrderCollection(
                $query->paginate(5)
            )
        );
        return $this->getResponse();
    }

    /**
     * Purchase
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'voucher_code' => 'string',
        ]);

        if ($validator->fails()) {
            $this->setValidationErrors($validator->errors()->toArray());
            return $this->getResponse();
        }

        $purchaseOrder = new PurchaseOrder;
        $purchaseOrder->purchase($request->id, $request->voucher_code);

        if ($purchaseOrder->getError()) {
            $this->setValidationErrors(['voucher_code' => [__($purchaseOrder->getError())]]);
            return $this->getResponse();
        }

        return $this->getResponse();
    }
}
