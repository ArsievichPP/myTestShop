<?php

namespace App\Http\Controllers;

use App\Models\DeliveryMethod;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $quantity = session()->get('idAndQuantity');
        if ($quantity != null) {
            $products = Product::query()->select(['id', 'name', 'image', 'price'])->whereIn('id', array_keys($quantity))->get();
            $sum = 0;
            foreach ($products as $product) {
                $sum += ($product->price * $quantity[$product->id]);
            }
            $deliveryMethods = DeliveryMethod::all();
            return view('cart', ['products' => $products, 'quantity' => $quantity, 'sumPrice' => $sum, 'deliveryMethods' => $deliveryMethods]);
        }
        return view('cart');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $idAndQuantity = session()->pull('idAndQuantity');
        $idAndQuantity[$request->id] = $request->quantity;
        session()->put('idAndQuantity', $idAndQuantity);
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy(int $id)
    {
        $idAndQuantity = session()->pull('idAndQuantity');
        unset($idAndQuantity[$id]);
        session()->put('idAndQuantity', $idAndQuantity);
        if (in_array($id, $idAndQuantity)){
            return true;
        }
        return false;
    }
}
