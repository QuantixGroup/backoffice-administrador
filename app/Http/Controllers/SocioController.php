<?php

namespace App\Http\Controllers;
use App\Models\Socio;

use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function vistaSocios()
{
    return view("socios");
}
}
