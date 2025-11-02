<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => 'Dashboard - COVIMT 17'])
    @include('partials.sidebar')
    @if(session('ok'))
        <meta name="success-message" content="{{ session('ok') }}">
    @endif
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
                    <h2 class="mt-4 text-left ">Hola {{ auth()->user()->name ?? auth()->user()->cedula }}</h2>
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
                                        <th>Documento</th>
                                        <th class="d-none d-md-table-cell">Email</th>
                                        <th class="d-none d-md-table-cell">Teléfono</th>
                                        <th class="d-none d-lg-table-cell">Fecha de Nacimiento</th>
                                        <th class="d-none d-lg-table-cell">Departamento</th>
                                        <th class="d-none d-lg-table-cell">Situación Laboral</th>
                                        <th class="d-none d-xl-table-cell">Ingresos Mensuales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sociosPendientes as $socio)
                                        <tr class="table-row-selectable" data-cedula="{{ $socio->cedula }}">
                                            <td>{{ $socio->nombre ?? 'N/A' }} {{ $socio->apellido ?? '' }}</td>
                                            <td>{{ $socio->cedula ?? 'N/A' }}</td>
                                            <td class="d-none d-md-table-cell">{{ $socio->email ?? 'N/A' }}</td>
                                            <td class="d-none d-md-table-cell">{{ $socio->telefono ?? 'N/A' }}</td>
                                            <td class="d-none d-lg-table-cell">
                                                {{ $socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                            </td>
                                            <td class="d-none d-lg-table-cell">{{ $socio->departamento ?? 'N/A' }}</td>
                                            <td class="d-none d-lg-table-cell">{{ $socio->situacion_laboral ?? 'N/A' }}</td>
                                            <td class="d-none d-xl-table-cell">
                                                {{ $socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
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
</body>

</html>