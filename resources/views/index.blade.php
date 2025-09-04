@extends('estructura.header')

@section('content')
    <h2>Bienvenido al Backoffice</h2>
    <p>Usá el menú para navegar.</p>

    <ul>
        <li><a href="/socios/pendientes">Ver socios pendientes</a></li>
        <li><a href="/logout">Cerrar sesión</a></li>
    </ul>
@endsection

@include('estructura.footer')
