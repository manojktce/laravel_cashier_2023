<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Stripe;

class PlanController extends Controller
{
    public function index()
    {
        /*$stripe = new \Stripe\StripeClient('sk_test_9v7nEOAi1RbQ8SPfxsrLWpDo');
        $st = $stripe->subscriptions->retrieve(
            'sub_1NUqumKNn8u3628oKvzPFjeU',
            []
        );*/

        /*$stripe = new \Stripe\StripeClient('sk_test_9v7nEOAi1RbQ8SPfxsrLWpDo');
        $st = $stripe->subscriptions->all(['limit' => 3]);
        echo "<pre>"; print_r($st); exit;*/

        $plans = Plan::get();
        return view("plans",compact("plans"));
    }

    public function show(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        return view("subscription", compact("plan", "intent"));
    }

    public function subscription(Request $request)
    {
        $plan = Plan::find($request->plan);
        $subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);
        return view("subscription_success");
    }

    public function one_time_purchase(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        
        $payment = Stripe\Charge::create ([
                "amount" => ( 7 * 1) * 100,
                "currency" => "usd",
                "source" => $request->token,
                "description" => "Single time purchase payment", 
        ]);

        return view("subscription_success");
    }
}
