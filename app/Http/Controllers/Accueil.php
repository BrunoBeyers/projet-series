<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Accueil extends Controller
{
    public function index()
    {
        return view('web.accueil');
    }
}
