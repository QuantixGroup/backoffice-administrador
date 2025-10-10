<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    @if(session('ok'))
        <meta name="success-message" content="{{ session('ok') }}">
    @endif
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="success-notification" id="successNotification">
            <i class="fas fa-check-circle"></i>
            <span id="successMessage"></span>
        </div>

        <div class="container-fluid">
            <div class="form-container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->nombre ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->apellido ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" value="{{ $socio->email ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Departamento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->departamento ?? '' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Ingresos Mensuales</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : '' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Estado Civil</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->estado_civil ?? '' }}"
                                    disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Documento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->cedula ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : '' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Teléfono</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->telefono ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Ciudad</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->ciudad ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Situación Laboral</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->situacion_laboral ?? '' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Cantidad de Integrantes</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->integrantes_familiares ?? '' }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">¿Por qué desea unirse a nuestra cooperativa de
                                viviendas?</label>
                            <textarea class="form-control textarea-large" rows="8"
                                disabled>{{ $socio->motivacion ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="button" class="btn-reject" onclick="showRejectModal()">
                        Rechazar Usuario
                    </button>
                    <button type="button" class="btn-approve" onclick="showApproveModal()">
                        Aceptar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="approveModal">
        <div class="modal-content">
            <div class="modal-title">¿Está seguro que desea aceptar la solicitud?</div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="hideApproveModal()">Cancelar</button>
                <button class="btn-modal-confirm btn-aprobar" data-cedula="{{ $socio->cedula }}"
                    onclick="approveUser()">Aceptar</button>
            </div>
        </div>
    </div>


    <div class="modal-overlay" id="rejectModal">
        <div class="modal-content">
            <div class="modal-title">¿Está seguro que desea rechazar la solicitud?</div>
            <div class="modal-buttons">
                <button class="btn-modal-cancel" onclick="hideRejectModal()">Cancelar</button>
                <button class="btn-modal-confirm" onclick="rejectUser()">Aceptar</button>
            </div>
        </div>
    </div>

    <form id="approveForm" method="POST" action="{{ route('socios.aprobar', $socio->cedula) }}" style="display: none;">
        @csrf
    </form>

    <form id="rejectForm" method="POST" action="{{ route('socios.rechazar', $socio->cedula) }}" style="display: none;">
        @csrf
    </form>

    @include('partials.footer')
</body>

</html>