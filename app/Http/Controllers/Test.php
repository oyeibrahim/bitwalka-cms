<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Test extends Controller
{
    //

    function index(Request $request)
    {

        echo app()->getLocale().RouteServiceProvider::HOME;
        
        // echo DB::table('users')->where('email', "f6513f231a-6bc8be@inbox.mailtrap.io")->value('status');

        // echo DB::table('roles')->orderBy('number', 'desc')->value('name');

        // if ($request->has('data')) {
        //     echo $request->input('data');
        // } else {
        //     echo "Query not detected";
        // }
    }
}
