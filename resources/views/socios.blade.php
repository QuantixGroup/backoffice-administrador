@include(view: 'estructura.header')

@if (session('ok'))
<div style="color:green">{{ session('ok') }}</div> @endif
@if (session('error'))
<div style="color:red">{{ session('error') }}</div> @endif

<h2>Socios pendientes</h2>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Situación laboral</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($sociosPendientes as $socio)
            <tr>
                <td>{{ $socio->cedula }}</td>
                <td>{{ $socio->nombre }}</td>
                <td>{{ $socio->apellido }}</td>
                <td>{{ $socio->email }}</td>
                <td>{{ $socio->situacion_laboral ?? '-' }}</td>
                <td>
                    <form method="POST" action="{{ route('socios.aprobar', $socio->cedula) }}">
                        @csrf
                        <button type="submit">Aprobar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay socios pendientes.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@include('estructura.footer')