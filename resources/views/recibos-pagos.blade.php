<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => 'Recibos de Pago - COVIMT 17'])
    <meta name="recibos-detalle-url" content="{{ route('recibos.detalle') }}">
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table-container mt-4">
                        <div class="table-header mt-5 text-center">
                            <h2 class="mb-0">Recibos de Pago</h2>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="recibosTable" class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Horas Trabajadas</th>
                                    <th>Estado de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sociosAprobados as $socio)
                                    <tr class="table-row-selectable" data-cooperativista="{{ $socio->cedula ?? 'N/A' }}">
                                        <td>{{ $socio->nombre ?? 'N/A' }}</td>
                                        <td>{{ $socio->apellido ?? 'N/A' }}</td>
                                        <td>{{ $socio->cedula ?? 'N/A' }}</td>
                                        <td>{{ $socio->telefono ?? 'N/A' }}</td>
                                        <td>{{ $socio->email ?? 'N/A' }}</td>
                                        <td>
                                            {!! $socio->horas_trabajadas_badge !!}
                                        </td>
                                        <td>
                                            {!! $socio->estado_pago_badge !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay cooperativistas aprobados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="action-buttons">
                        <div class="row">
                            <div class="col-12 text-end">
                                <button id="abrirReciboBtn" class="btn-ver-recibo" onclick="abrirRecibo()" disabled>
                                    Ver Recibos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>