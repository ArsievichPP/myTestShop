<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\ShoppingList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function store(Request $request)
    {
//        DB::transaction(function () use ($request) { //todo Не смог придумать как получить id покупателя и заказа (так как пока транзакция не завешится, этих данных нет в бд)

        $orderId = Order::query()->insertGetId([  // todo мне кажется с таблицей customers было лучше, так как теперь заказать товар может только
                                                  // todo зарегистрированны пользователь и только на сое имя и адресс
            'customer_id' => Auth::id(),
            'delivery' => $request->delivery
        ]);

        $shoppingList = new ShoppingList();
        $shoppingList->create($orderId);
//         });

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
