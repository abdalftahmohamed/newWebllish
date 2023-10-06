<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Subscription;
use Stripe\Customer;
use Stripe\Plan;
use Stripe\Stripe;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //    $plans = $this->retrievePlans();
        $user = auth()->user();

        return view('dashboard', [
            'user'=>$user,
            'intent' => $user->createSetupIntent(),
//        'plans' => $plans
        ]);
    }
}
