<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head', ['title' => 'Cooperativistas - COVIMT 17'])
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="table-container mt-4">
                        <div class="table-header mt-5 text-center">
                            <h2 class="mb-0">Listado de Cooperativistas</h2>
                        </div>

                        <div class="mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" id="searchCedula" class="form-control"
                                            placeholder="Buscar por documento..." maxlength="8">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-8 text-md-end">
                                    <span id="searchResults" class="text-muted"></span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="cooperativistasTable" class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Documento</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Fecha de Aprobación</th>
                                        <th>Horas Trabajadas</th>
                                        <th>Estado de Pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sociosAprobados as $socio)
                                        <tr class="table-row-selectable" data-cedula="{{ $socio->cedula }}">
                                            <td>{{ $socio->nombre ?? 'N/A' }}</td>
                                            <td>{{ $socio->apellido ?? 'N/A' }}</td>
                                            <td>{{ $socio->cedula ?? 'N/A' }}</td>
                                            <td>{{ $socio->telefono ?? 'N/A' }}</td>
                                            <td>{{ $socio->email ?? 'N/A' }}</td>
                                            <td>{{ $socio->updated_at ? $socio->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                {!! $socio->horas_trabajadas_badge !!}
                                            </td>
                                            <td>
                                                {!! $socio->estado_pago_badge !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No hay cooperativistas aprobados aún
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>