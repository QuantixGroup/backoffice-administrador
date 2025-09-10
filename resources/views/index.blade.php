<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .table-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            background-color: #1b4965;
            color: #ffffff;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 1rem 0.75rem;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .table tbody tr {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table tbody tr.selected {
            background-color: #e3f2fd;
            border-left: 4px solid #1b4965;
        }

        .btn-abrir {
            background-color: #1b4965;
            color: #ffffff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.25rem;
            font-weight: 500;
        }

        .btn-abrir:hover:not(:disabled) {
            background-color: #3693CB;
            color: #ffffff;
        }

        .btn-abrir:disabled {
            background-color: #6c757d;
            color: #ffffff;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .action-buttons {
            padding: 1rem 1.5rem;
            background-color: #ffffff;
            border-top: 1px solid #dee2e6;
        }

        /* Success notification styles */
        .success-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #28a745;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.375rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1060;
            display: none;
            min-width: 300px;
        }

        .success-notification.show {
            display: flex;
            align-items: center;
            animation: slideInRight 0.3s ease-out;
        }

        .success-notification i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    @include('partials.sidebar')

    <!-- Success notification -->
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
                        <div class="table-header">
                            Usuarios pendientes
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

    <script>
        let selectedRow = null;
        let selectedCedula = null;

        // Agregar event listeners a todas las filas
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.user-row');
            const abrirBtn = document.getElementById('abrirBtn');

            rows.forEach(row => {
                row.addEventListener('click', function () {
                    // Remover selección anterior
                    if (selectedRow) {
                        selectedRow.classList.remove('selected');
                    }

                    // Seleccionar nueva fila
                    selectedRow = this;
                    selectedCedula = this.getAttribute('data-cedula');
                    this.classList.add('selected');

                    // Habilitar botón Abrir
                    abrirBtn.disabled = false;
                });
            });

            // Mostrar notificación de éxito si hay mensajes de sesión
            @if(session('ok'))
                showSuccessNotification("{{ session('ok') }}");
            @endif
        });

        function abrirDetalle() {
            if (selectedCedula) {
                window.location.href = `{{ url('/socios') }}/${selectedCedula}/detalle`;
            }
        }

        function showSuccessNotification(message) {
            const notification = document.getElementById('successNotification');
            const messageSpan = document.getElementById('successMessage');

            messageSpan.textContent = message;
            notification.classList.add('show');

            // Ocultar la notificación después de 4 segundos
            setTimeout(function () {
                notification.classList.remove('show');
            }, 4000);
        }
    </script>
</body>

</html>