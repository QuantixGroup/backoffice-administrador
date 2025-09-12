<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => 'Recibos de Pago - COVIMT 17'])
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="recibos-detalle-container">
            <div class="table-header text-center">
                <h2 class="mb-0">Detalles de recibos de pagos</h2>
            </div>

            <div class="content-wrapper">
                <div class="cooperativista-info">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" value="{{ $cooperativista->nombre ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" id="apellido" value="{{ $cooperativista->apellido ?? '' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="documento">Documento:</label>
                        <input type="text" id="documento" value="{{ $cooperativista->cedula ?? '' }}" readonly>
                    </div>
                </div>

                <div class="recibos-table-container">
                    <div class="recibos-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Nombre</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recibos) && count($recibos) > 0)
                                    @foreach($recibos as $recibo)
                                        <tr>
                                            <td>{{ $recibo['numero'] ?? 'Data' }}</td>
                                            <td>{{ $recibo['nombre_completo'] ?? 'Data' }}</td>
                                            <td>{{ $recibo['mes'] ?? 'Data' }}</td>
                                            <td>{{ $recibo['año'] ?? 'Data' }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    @for($i = 1; $i <= 8; $i++)
                                        <tr>
                                            <td>Data</td>
                                            <td>Data</td>
                                            <td>Data</td>
                                            <td>Data</td>
                                        </tr>
                                    @endfor
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>