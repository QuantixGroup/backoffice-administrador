@include('partials.head')

<body class="body-background">
  <div class="login-overlay"></div>
  <main>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="logo-container">
            <img src="{{ asset('img/logo_cooperativa.svg') }}" alt="Logo">
            <div class="logo-text">COVIMT 17</div>
          </div>
          <div class="login-card">
            <h2 class="login-title">Iniciar sesión</h2>
            @if ($errors->any())
              <div class="alert alert-danger text-center">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('login.post') }}">
              @csrf
              <div class="mb-3">
                <label for="cedula" class="form-label">Usuario (CI)</label>
                <input type="text" name="cedula" id="cedula" class="form-control" placeholder="Ingrese su Documento">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Su contraseña">
              </div>
              <button type="submit" class="btn-login w-100 mb-2">
                <i class="bi bi-box-arrow-in-right"></i> Entrar
              </button>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember" name="remember">
                  <label class="form-check-label" for="remember">Recordar</label>
                </div>
                <a href="#" class="text-decoration-none">¿Olvidó su contraseña?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @vite(['resources/js/app.js'])
</body>