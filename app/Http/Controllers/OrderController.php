<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $idAndQuantity = session()->get('idAndQuantity');
            $total_price = 0;
            $shoppingLists = [];

            foreach ($idAndQuantity as $id => $quantity) {
                $product = Product::query()->lockForUpdate()->find($id);

                $shoppingLists[] = new ShoppingList([
                    'product_id' => $id,
                    'quantity' => $quantity,
                    'unit_price' => $product->value('price'),
                ]);

                $total_price += $product->value('price') * $quantity;
                $product->decrement('quantity', $quantity);
            }
            $order = Order::query()->create([
                'customer_id' => Auth::id(),
                'delivery' => $request->delivery,
                'total_price' => $total_price,
            ]);

            $order->shoppingLists()->saveMany($shoppingLists);

            session()->forget('idAndQuantity');
        });

        return view('confirmation');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $idAndQuantity = $request->session()->pull('idAndQuantity');
        $idAndQuantity[$request->id] = $request->quantity;
        session()->put('idAndQuantity', $idAndQuantity);
        return back()->withInput();
    }
}
