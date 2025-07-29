<?php

namespace App\Http\Controllers;
use App\Models\Socio;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class SocioController extends Controller
{
    public function vistaSocios()
    {
        $response = Http::get('http://localhost:8000/api/socios');
        $socios = $response->json();
        return view('socios', compact('socios'));
    }
}
