<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        .form-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-control {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            border-radius: 0.375rem;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            opacity: 1;
        }

        .btn-back {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: #ffffff;
            text-decoration: none;
        }

        .btn-reject {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.25rem;
            font-weight: 500;
        }

        .btn-reject:hover {
            background-color: #c82333;
        }

        .btn-approve {
            background-color: #28a745;
            color: #ffffff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.25rem;
            font-weight: 500;
        }

        .btn-approve:hover {
            background-color: #218838;
        }

        .textarea-large {
            min-height: 120px;
            resize: vertical;
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: none;
        }

        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .modal-title {
            margin-bottom: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .modal-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .btn-modal-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .btn-modal-confirm {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        .btn-modal-cancel:hover {
            background-color: #5a6268;
        }

        .btn-modal-confirm:hover {
            background-color: #0056b3;
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

    <div class="main-content">
        <!-- Success notification -->
        <div class="success-notification" id="successNotification">
            <i class="fas fa-check-circle"></i>
            <span id="successMessage"></span>
        </div>

        <div class="container-fluid">
            <div class="form-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" value="{{ $socio->nombre ?? 'Agusto' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellido</label>
                            <input type="text" class="form-control" value="{{ $socio->apellido ?? 'Medina' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control"
                                value="{{ $socio->email ?? 'agusto.medina@gmail.com' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Departamento</label>
                            <input type="text" class="form-control" value="{{ $socio->departamento ?? 'Montevideo' }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ocupación</label>
                            <input type="text" class="form-control" value="{{ $socio->ocupacion ?? '' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ingresos Mensuales</label>
                            <input type="text" class="form-control"
                                value="{{ $socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : '$35000' }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comprobante de Ingresos</label>
                            <div>
                                <button type="button" class="btn btn-outline-primary btn-sm">Ver archivo
                                    adjunto</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Estado Civil</label>
                            <input type="text" class="form-control" value="{{ $socio->estado_civil ?? '' }}" disabled>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Documento</label>
                            <input type="text" class="form-control" value="{{ $socio->cedula ?? '12345678' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="text" class="form-control"
                                value="{{ $socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : '11/11/2001' }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" value="{{ $socio->telefono ?? '090000000' }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ciudad</label>
                            <input type="text" class="form-control" value="{{ $socio->ciudad ?? 'Montevideo' }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Situación Laboral</label>
                            <input type="text" class="form-control"
                                value="{{ $socio->situacion_laboral ?? 'Empleado/a' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cantidad de Integrantes</label>
                            <input type="text" class="form-control" value="{{ $socio->cantidad_integrantes ?? '3' }}"
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Integrantes del Núcleo Familiar</label>
                            <input type="text" class="form-control"
                                value="{{ $socio->integrantes_nucleo_familiar ?? '' }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">¿Por qué desea unirse a nuestra cooperativa de viviendas?</label>
                            <textarea class="form-control textarea-large"
                                disabled>{{ $socio->motivacion ?? 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-6">
                        <a href="{{ route('home') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                    <div class="col-6 text-end">
                        <button type="button" class="btn-reject" onclick="showRejectModal()">
                            Rechazar Usuario
                        </button>
                        <button type="button" class="btn-approve ms-2" onclick="showApproveModal()">
                            Aceptar Usuario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para aprobar -->
    <div class="modal-overlay" id="approveModal">
        <div class="modal-content">
            <div class="modal-title">¿Está seguro que desea aceptar la solicitud?</div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="hideApproveModal()">Cancelar</button>
                <button class="btn-modal-confirm" onclick="approveUser()">Aceptar</button>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación para rechazar -->
    <div class="modal-overlay" id="rejectModal">
        <div class="modal-content">
            <div class="modal-title">¿Está seguro que desea rechazar la solicitud?</div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="hideRejectModal()">Cancelar</button>
                <button class="btn-modal-confirm" onclick="rejectUser()">Aceptar</button>
            </div>
        </div>
    </div>

    <!-- Formularios ocultos -->
    <form id="approveForm" method="POST" action="{{ route('socios.aprobar', $socio->cedula) }}" style="display: none;">
        @csrf
    </form>

    <form id="rejectForm" method="POST" action="{{ route('socios.rechazar', $socio->cedula) }}" style="display: none;">
        @csrf
    </form>

    <script>
        // Funciones para mostrar/ocultar modales
        function showApproveModal() {
            document.getElementById('approveModal').style.display = 'block';
        }

        function hideApproveModal() {
            document.getElementById('approveModal').style.display = 'none';
        }

        function showRejectModal() {
            document.getElementById('rejectModal').style.display = 'block';
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        // Funciones para ejecutar las acciones
        function approveUser() {
            hideApproveModal();
            document.getElementById('approveForm').submit();
        }

        function rejectUser() {
            hideRejectModal();
            document.getElementById('rejectForm').submit();
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function (event) {
            const approveModal = document.getElementById('approveModal');
            const rejectModal = document.getElementById('rejectModal');

            if (event.target === approveModal) {
                hideApproveModal();
            }
            if (event.target === rejectModal) {
                hideRejectModal();
            }
        }

        // Mostrar notificación de éxito si hay mensajes de sesión
        @if(session('ok'))
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessNotification("{{ session('ok') }}");
            });
        @endif

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

    @include('partials.footer')
</body>

</html>