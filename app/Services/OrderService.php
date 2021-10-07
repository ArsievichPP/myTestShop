<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use StateMachine;

class OrderService extends Service
{
    public function createOrder()
    {
        $order = null;

        DB::transaction(function () use (&$order) {
            $idAndQuantity = session()->get('idAndQuantity');
            $total_price = 0;
            $shoppingLists = [];

            foreach ($idAndQuantity as $id => $quantity) {
                $product = Product::query()->lockForUpdate()->find($id);
                $shoppingLists[] = new ShoppingList([
                    'product_id' => $id,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                ]);

                $total_price += $product->price * $quantity;
                $product->decrement('quantity', $quantity);
            }

            $order = Order::query()->create([
                'customer_id' => Auth::id(),
                'total_price' => $total_price,
            ])->fresh();

            $stateMachine = StateMachine::get($order, 'orders');
            if ($stateMachine->apply('approve_new_order', false)) {
                $order->save();
            }
            $order->shoppingLists()->saveMany($shoppingLists);
            session()->forget('idAndQuantity');
        });
        return $order;
    }
}
