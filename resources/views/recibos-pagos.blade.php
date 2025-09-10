<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body>
    @include('partials.sidebar')

    <div class="main-content">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-0">Recibos de Pago</h2>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="table-container">
                        <div class="table-header">
                            Gestión de Recibos de Pago
                        </div>
                        <div class="table-responsive">
                            <p class="p-4 text-muted">Contenido de recibos de pago...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
</body>

</html>
