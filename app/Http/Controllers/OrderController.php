<?php

namespace App\Http\Controllers;


use App\DTO\OrderRequestDTO;
use App\DTO\PaymentRequestDTO;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use StateMachine;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $orders = Order::query()->
        with('shoppingLists.product')->
        where('customer_id', Auth::user()->getAuthIdentifier())->
        orderByDesc('id')->
        get();
        return view('orders', ['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws UnknownProperties
     */
    public function store(Request $request)
    {
        $orderService = new OrderService();
        $orderService->createOrder();

        return view('confirmation');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public
    function update(Request $request): RedirectResponse
    {
        $idAndQuantity = $request->session()->pull('idAndQuantity');
        $idAndQuantity[$request->id] = $request->quantity;
        session()->put('idAndQuantity', $idAndQuantity);
        return back()->withInput();
    }
}
