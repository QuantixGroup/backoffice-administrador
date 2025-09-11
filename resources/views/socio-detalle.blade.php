<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="success-notification" id="successNotification">
            <i class="fas fa-check-circle"></i>
            <span id="successMessage"></span>
        </div>

        <div class="container-fluid">
            <div class="form-container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Nombre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->nombre ?? 'Agusto' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Apellido</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->apellido ?? 'Medina' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control"
                                    value="{{ $socio->email ?? 'agusto.medina@gmail.com' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Departamento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->departamento ?? 'Montevideo' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Ingresos Mensuales</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->ingresos_mensuales ? '$' . number_format($socio->ingresos_mensuales, 0, ',', '.') : '$35000' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Comprobante de Ingresos</label>
                            <div class="col-sm-8">
                                <button type="button" class="btn-ver-archivo">Ver archivo
                                    adjunto</button>
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
                                <input type="text" class="form-control" value="{{ $socio->cedula ?? '12345678' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Fecha de Nacimiento</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->fecha_nacimiento ? \Carbon\Carbon::parse($socio->fecha_nacimiento)->format('d/m/Y') : '11/11/2001' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Teléfono</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->telefono ?? '090000000' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Ciudad</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ $socio->ciudad ?? 'Montevideo' }}"
                                    disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Situación Laboral</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->situacion_laboral ?? 'Empleado/a' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Cantidad de Integrantes</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->cantidad_integrantes ?? '3' }}" disabled>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">Integrantes del Núcleo Familiar</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"
                                    value="{{ $socio->integrantes_nucleo_familiar ?? '' }}" disabled>
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
                                disabled>{{ $socio->motivacion ?? 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center mt-4">
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

    <script>
        @if(session('ok'))
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessNotification("{{ session('ok') }}");
            });
        @endif
    </script>

    @include('partials.footer')
</body>

</html>