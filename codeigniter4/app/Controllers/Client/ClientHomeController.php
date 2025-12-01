<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;

class ClientHomeController extends BaseController
{
    public function index()
    {
        return view('Client/dashboard');
    }
}
