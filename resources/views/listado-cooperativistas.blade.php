<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: #ffffff;
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

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-0">Listado de Cooperativistas</h2>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="table-container">
                        <div class="table-header">
                            Cooperativistas Aprobados
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Documento</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Departamento</th>
                                        <th>Situación Laboral</th>
                                        <th>Fecha de Aprobación</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sociosAprobados as $socio)
                                        <tr>
                                            <td>{{ $socio->nombre ?? 'N/A' }}</td>
                                            <td>{{ $socio->apellido ?? 'N/A' }}</td>
                                            <td>{{ $socio->cedula ?? 'N/A' }}</td>
                                            <td>{{ $socio->email ?? 'N/A' }}</td>
                                            <td>{{ $socio->telefono ?? 'N/A' }}</td>
                                            <td>{{ $socio->departamento ?? 'N/A' }}</td>
                                            <td>{{ $socio->situacion_laboral ?? 'N/A' }}</td>
                                            <td>{{ $socio->updated_at ? $socio->updated_at->format('d/m/Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Aprobado</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-4">
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
