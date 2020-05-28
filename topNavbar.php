<?php
echo '<div class="mb-1">
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">El Garage de Welsh</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
        </button>';

echo '<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent"> 
        <ul class="navbar-nav">
            <li class="nav-item active">
            <a class="nav-link" href="" data-toggle="modal" data-target="#login">Iniciar sesión</a>
            </li>
            <li class="nav-item active">
            <a class="nav-link" href="createAcc.php">Crear cuenta</a>
            </li>
        </ul>
        </div>';

echo '</nav>
    </div>';

echo '<div class="modal fade" id="login" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Iniciar sesión</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="inputEmail">Correo electrónico</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="Correo electrónico">
              </div>
              <div class="form-group">
                <label for="inputPassword">Contraseña</label>
                <input type="password" class="form-control" id="inputPassword" placeholder="Contraseña">
              </div>
              <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            </form>
          </div>
        </div>
      </div>
    </div>';
?>