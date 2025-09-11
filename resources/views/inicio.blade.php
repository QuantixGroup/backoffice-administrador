<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => 'Dashboard - COVIMT 17'])
    @include('partials.sidebar')
</head>

<body>
    <div class="success-notification" id="successNotification">
        <i class="fas fa-check-circle"></i>
        <span id="successMessage"></span>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-0">Hola {{ auth()->user()->name ?? auth()->user()->cedula }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-container">
                        <div class="table-header text-center">
                            <h2>Usuarios pendientes</h2>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Documento</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Departamento</th>
                                        <th>Situación Laboral</th>
                                        <th>Ingresos Mensuales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sociosPendientes as $socio)
                                        <tr class="user-row" data-cedula="{{ $socio->cedula }}">
                                            <td>{{ $socio->nombre ?? 'N/A' }}</td>
                                            <td>{{ $socio->apellido ?? 'N/A' }}</td>
                                            <td>{{ $socio->cedula ?? 'N/A' }}</td>
                                            <td>{{ $socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            <td>{{ $socio->email ?? 'N/A' }}</td>
                                            <td>{{ $socio->telefono ?? 'N/A' }}</td>
                                            <td>{{ $socio->departamento ?? 'N/A' }}</td>
                                            <td>{{ $socio->situacion_laboral ?? 'N/A' }}</td>
                                            <td>{{ $socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
                                                No hay usuarios pendientes de aprobación
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="action-buttons">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button id="abrirBtn" class="btn-abrir" onclick="abrirDetalle()" disabled>
                                        Abrir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

    @if(session('ok'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessNotification("{{ session('ok') }}");
            });
        </script>
    @endif
</body>

</html>