<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EnclosureController extends Controller
{
    public function index()
    {
        return view('enclosures.index');
    }
}
