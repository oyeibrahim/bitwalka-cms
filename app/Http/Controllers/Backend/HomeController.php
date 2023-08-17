<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function home()
    {
        return view('backend/home', ['page_name' => 'admin_home', 'page_title' => 'Admin Dashboard']);
    }
}
