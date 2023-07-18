<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use Stripe;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
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
        /*$subscription = $request->user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);*/
        $subscription = Auth::user()->newSubscription($request->plan, $plan->stripe_plan)
                        ->create($request->token);
        return redirect()->route('plans')->with('success','Payment successful for subscription');
    }

    public function purchase(Plan $plan, Request $request)
    {
        $intent = auth()->user()->createSetupIntent();
        return view("purchase", compact("plan", "intent"));
    }

    public function one_time_purchase(Request $request)
    {
        $plan = Plan::find($request->plan);

        /*$stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $stripe->charges->create([
            'amount' => $plan->price * 100,
            'currency' => 'usd',
            'source' => 'tok_mastercard',
            'description' => 'Test Single time payment',
        ]);*/

        $user = Auth::user();
        $user->charge($plan->price * 100, $request->token);

        return redirect()->route('plans')->with('success','Payment successful');
    }
}
