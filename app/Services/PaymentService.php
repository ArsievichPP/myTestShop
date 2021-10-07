<?php

namespace App\Services;

use App\DTO\PaymentRequestDTO;
use App\Models\Order;
use App\Models\Payment;
use Stripe;
use StateMachine;

class PaymentService extends Service
{
    public function createPayment(Order $order){
        $payment = Payment::query()->create()->fresh();
        $order->payment_id = $payment->id;
        $order->save();
    }

    public function stripePayment(PaymentRequestDTO $request, Order $order)
    {
        $payment = $order->payment;

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $response = Stripe\Charge::create([
            "amount" => $order->total_price * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "This payment is tested purpose",
            "shipping" =>
                [
                    "name" => $request->name,
                    "address" => ["city" => $request->address],
                    "phone" => $request->phone,
                ],
            "receipt_email" => $request->email,
        ]);

        $payment->payment_id = $response->id;
        $payment->method = 'Stripe';
        $payment->save();

        $order->delivery = $request->delivery;
        $order->save();

        $paymentState = StateMachine::get($payment, 'payments');
        if ($paymentState->apply('pay', false, ['response' => $response])) {
            $payment->save();
        }

        $orderState = StateMachine::get($order, 'orders');
        if ($orderState->apply('pay_order', false)) {
            $order->save();
        }
    }

    public function stripeRefund(Order $order)
    {

        $payment = $order->payment;

        $paymentState = StateMachine::get($payment, 'payments');
        if ($paymentState->apply('refund', false)) {
            $payment->save();
        }

        $orderState = StateMachine::get($order, 'orders');
        if ($orderState->apply('refund', false)) {
            $order->save();
        }
    }
}
