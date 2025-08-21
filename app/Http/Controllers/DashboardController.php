<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $name = 'Samir';
        //return data with view
        // (1) only array with multiple variables
        return view('dashboard.index', ['name' => 'Samir']);

        // (2) with function {{ compact }} ==>pass only variables
        return view('dashboard.index', compact('name'));

        // (3) with function {{ with }} ==>pass only variables
        return view('dashboard.index')->with('name', 'Samir');

        //(4) with function {{ response }}
        return response()->view('dashboard.index', compact('name'));

        //(5) with facades
        return View::make('dashboard.index', compact('name'));
        return Response::view('dashboard.index', compact('name'));
    }
}
