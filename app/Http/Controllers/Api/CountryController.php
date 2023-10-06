<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
       $country= Country::with('cities')->get();
        return response()->json([
            'status'=>true,
            'message' => 'successfully',
            'token_type' =>$country,
        ]);
    }
}
