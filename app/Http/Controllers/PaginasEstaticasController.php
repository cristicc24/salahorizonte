<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaginasEstaticasController extends Controller
{
    public function faq()
    {
        return view('faq');
    }

    public function terminos()
    {
        return view('terminos');
    }
}
