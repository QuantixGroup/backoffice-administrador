<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => 'Recibos de Pago - COVIMT 17'])
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="success-notification" id="successNotification">
            <i class="fas fa-check-circle"></i>
            <span id="successMessage"></span>
        </div>

        <div class="recibos-detalle-container mt-4">
            <div class="table-header text-center mt-5">
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
                                    <th>Monto</th>
                                    <th>Mes</th>
                                    <th>Año</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recibos) && count($recibos) > 0)
                                    @foreach($recibos as $recibo)
                                        <tr data-recibo-id="{{ $recibo['id_pago'] ?? '' }}">
                                            <td>{{ $recibo['numero'] ?? '' }}</td>
                                            <td>{{ $recibo['monto'] ?? '' }}</td>
                                            <td>{{ $recibo['mes'] ?? '' }}</td>
                                            <td>{{ $recibo['año'] ?? '' }}</td>
                                            <td>
                                                <select class="estado-select" data-id="{{ $recibo['id_pago'] ?? '' }}"
                                                    data-original-estado="{{ $recibo['estado'] ?? 'pendiente' }}">
                                                    <option value="pendiente" {{ ($recibo['estado'] ?? '') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                                    <option value="aceptado" {{ ($recibo['estado'] ?? '') == 'aceptado' ? 'selected' : '' }}>Aceptado</option>
                                                    <option value="rechazado" {{ ($recibo['estado'] ?? '') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No hay recibos disponibles</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if(isset($recibos) && count($recibos) > 0)
                        <div class="text-center mt-4 mb-4">
                            <button id="guardarCambiosBtn" class="btn-guardar-cambios" disabled>
                                Guardar
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>