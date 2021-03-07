<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController_old extends Controller
{
    public function updateStatus(Request $request)
    {
        dd('here', $request->all());
    }
}