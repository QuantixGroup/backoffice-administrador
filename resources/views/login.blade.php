@include(view: 'estructura.header')

<h2>Login de Administrador</h2>

@if ($errors->any())
    <div style="color:red">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('login.post') }}">
  @csrf

  <label>Cédula</label><br>
  <input type="text" name="cedula"><br><br>

  <label>Contraseña</label><br>
  <input type="password" name="password"><br><br>

  <button type="submit">Ingresar</button>
</form>

@include('estructura.footer')