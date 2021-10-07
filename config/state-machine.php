<?php

use App\Models\Order;
use App\Models\Payment;
use SM\Event\TransitionEvent;

return [
    'orderStatus' => [
        // class of your domain object
        'class' => Order::class,

        // name of the graph (default is "default")
        'graph' => 'orders',

        // property of your object holding the actual state (default is "state")
        'property_path' => 'status',

        'metadata' => [
        ],

        // list of all possible states
        'states' => [
            'new',
            'Awaiting payment',
            'Payment accepted',
            'Processing in progress',
            'Ready for delivery',
            'Shipped',
            'Delivered',
            'Completed',
            'Canceled',
            'Refunded',
        ],

        // list of all possible transitions
        'transitions' => [
            'approve_new_order' => [
                'from' => ['new'],
                'to' => 'Awaiting payment',
            ],
            'pay_order' => [
                'from' => ['Awaiting payment'],
                'to' => 'Payment accepted',
            ],
            'refund' => [
                'from' => ['Payment accepted', 'Processing in progress', 'Ready for delivery'],
                'to' => 'Refunded',
            ]
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called when testing a transition
            'guard' => [
                'guard_approve_new_order' => [
                    // call the callback on a specific transition
                    'on' => 'approve_new_order',
                    // will call the method of this class
                    'do' => function () {
                        return true;
                    },
                ],
                'guard_pay_order' => [
                    // call the callback on a specific transition
                    'on' => 'pay_order',
                    // will call the method of this class
                    'do' => function (Order $order) {
                        if ($order->payment->paid_status === 'Complete')
                            return true;
                        return false;
                    },
                    'args' => ['object']
                ],
                'guard_refund' => [
                    'on' => 'refund',
                    'do' => function (Order $order) {
                        if ($order->payment->paid_status === 'Refunded')
                            return true;
                        return false;
                    },
                    'args' => ['object']
                ],
            ],

            // will be called before applying a transition
            'before' => [],

            // will be called after applying a transition
            'after' => [],
        ],
    ],
    'PaymentStatus' => [
        // class of your domain object
        'class' => Payment::class,

        // name of the graph (default is "default")
        'graph' => 'payments',

        // property of your object holding the actual state (default is "state")
        'property_path' => 'paid_status',

        'metadata' => [
        ],

        // list of all possible states
        'states' => [
            'Pending',
            'Complete',
            'Refunded',
            'Failed',
            'Abandoned',
            'Cancelled',
        ],

        // list of all possible transitions
        'transitions' => [
            'pay' => [
                'from' => ['Pending', 'Failed'],
                'to' => 'Complete',
            ],
            'refund' => [
                'from' => ['Complete'],
                'to' => 'Refunded'
            ]
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called when testing a transition
            'guard' => [
                'guard_pay' => [
                    'on' => 'pay',
                    'do' => function ($payment, TransitionEvent $event) {
                        return ($event->getContext()['response']->status === "succeeded");
                    },
                    'args' => ['object', 'event'],
                ],
                'guard_refund' => [
                    // call the callback on a specific transition
                    'on' => 'refund',
                    // will call the method of this class
                    'do' => function (Payment $payment) {
                        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                        $response = Stripe\Refund::create(
                            [
                                "charge" => $payment->payment_id
                            ]);
                        return $response->status === 'succeeded';
                    },
                    'args' => ['object']
                ],
            ],

            // will be called before applying a transition
            'before' => [],

            // will be called after applying a transition
            'after' => [],
        ],
    ],
];
