<?php 
  $email = $pass = null;

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["inputEmail"]) && !empty($_POST["inputPassword"])) {
    $email = test_input($_POST["inputEmail"]);
    $pass = test_input($_POST["inputPassword"]);
  }

  if (isset($email) && isset($pass)) {
    // SQL HERE - SQL HERE - SQL HERE - SQL HERE - SQL HERE -
    $_SESSION["userID"] = 1;
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<div class="mb-1">
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="index.php">El Garage de Welsh</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav">
      <?php 
        if (isset($_SESSION["userID"])) {
          // SQL HERE - SQL HERE - SQL HERE - SQL HERE
          echo '<li class="nav-item active">
                  <a class="nav-link" href="profile.php">Alfredo Welsh</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>';
        }
        else {
          echo '<li class="nav-item active">
                  <a class="nav-link" href="" data-toggle="modal" data-target="#login">Iniciar sesión</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="createAcc.php">Crear cuenta</a>
                </li>';
        }
      ?>
        </ul>
      </div>

    </nav>
</div>

<div class="modal fade" id="login" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Iniciar sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <div class="form-group">
            <label for="inputEmail">Correo electrónico</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="Correo electrónico" name="inputEmail" required>
          </div>
          <div class="form-group">
            <label for="inputPassword">Contraseña</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="Contraseña" name="inputPassword" required>
          </div>
          <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
        </form>
      </div>
    </div>
  </div>
</div>