<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainControllGuru extends Controller
{
    public function index()
    {
        return view('pages.guru.home');
    }
}