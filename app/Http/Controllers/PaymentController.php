<?php

namespace App\Http\Controllers;

use App\DTO\PaymentRequestDTO;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{

    public function show($order_id)
    {
        /** @var Order $order */
        $order = Order::query()->find($order_id);

        if (Auth::user()->getAuthIdentifier() !== $order->customer_id) {
            return back();
        }

        if (!isset($order->payment_id)) {
            $service = new PaymentService();
            $service->createPayment($order);
        }

        $deliveryMethods = DeliveryMethod::all();

        return view(
            'checkout', [
            'deliveryMethods' => $deliveryMethods,
            'order_id' => $order->id,
            'sum' => $order->total_price
        ]);
    }

    public function pay($order_id, Request $request){
        /** @var Order $order */
        $order = Order::query()->find($order_id);

        if (Auth::user()->getAuthIdentifier() !== $order->customer_id) {
            return back();
        }

        $dto_request = new PaymentRequestDTO($request->all());

        $service = new PaymentService();
        $service->stripePayment($dto_request, $order);
        return redirect(route('orders'));
    }

    public function refund($order_id)
    {
        /** @var Order $order */
        $order = Order::query()->with('payment')->find($order_id);
        if (Auth::user()->getAuthIdentifier() === $order->customer_id) {
            $service = new PaymentService();
            $service->stripeRefund($order);
        }
        return back();
    }


}
