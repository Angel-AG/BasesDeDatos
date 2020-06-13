<?php 
  session_start();

  if (isset($_SESSION["userID"])) {
    header("Location: index.php");
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
<?php include 'connectDB.php'?>
<?php 
  $fname = $lname = $email = $pass = $address = $noPhone = $cdCard = null;
  $fnameErr = $lnameErr = $emailErr = $passErr = $noPhoneErr = $cdCardErr = null;
  $allOK = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // SQL HERE - SQL HERE - SQL HERE - SQL HERE - SQL HERE -
    $allOK = true;

    $fname = !empty($_POST["fname"]) ? test_input($_POST["fname"]) : '';
    if (!preg_match("/^[a-zA-Z]+$/", $fname)) {
      $fnameErr = "Solo primer nombre";
      $allOK = false;
    }

    $lname = !empty($_POST["lname"]) ? test_input($_POST["lname"]) : '';
    if (!preg_match("/^[a-zA-Z]+$/", $lname)) {
      $lnameErr = "Solo apellido";
      $allOK = false;
    }
    
    $email = !empty($_POST["inputEmail"]) ? test_input($_POST["inputEmail"]) : '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $emailErr = "Correo no válido";
     $allOK = false;
    }
    else {
      if ($checkEmail = $conn->prepare("SELECT ID_Usuario
                                        FROM Usuario
                                        WHERE E_mail = ?;")) {
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
  
        $result = $checkEmail->get_result();
        if ($result->num_rows != 0) {
          $emailErr = "Correo ya está en uso";
          $allOK = false;
        }
      }
      else {
        $err = "Dificultades técnicas, intente después";
        $allOK = false;
      }
    }
    
    $pass = !empty($_POST["inputPassword"]) ? test_input($_POST["inputPassword"]) : '';
    if (strlen($pass) < 7) {
      $passErr = "Longitud del password minimo 7";
      $allOK = false;
    }

    $address = !empty($_POST["address"]) ? test_input($_POST["address"]) : '';

    $noPhone = !empty($_POST["phone"]) ? test_input($_POST["phone"]) : '';
    if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $noPhone) && !empty($noPhone)) {
      $noPhoneErr = "Respetar patrón: 123-456-7890";
      $allOK = false;
    }

    $cdCard = !empty($_POST["creditCard"]) ? test_input($_POST["creditCard"]) : '';
    if (!preg_match("/^[0-9]+$/", $cdCard) && !empty($cdCard)) {
      $cdCardErr= "Solamente números";
      $allOK = false;
    }

  }

  if ($allOK) {
    if ($nextIDUser = $conn->prepare("SELECT max(ID_Usuario) AS ID FROM usuario;")) {
        $nextIDUser->execute();
  
        $ID = 0;
        $result = $nextIDUser->get_result();
        if ($result->num_rows != 0) {
          $row = $result->fetch_assoc();
          $ID = $row["ID"] + 1;

          if ($addUser = $conn->prepare("INSERT INTO usuario (ID_Usuario, Nombre, Apellido, E_mail, No_Telefono, Direccion, Tarjeta, Contrasena, Fecha_de_creacion, Es_Administrador)
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 0);")) {
            $addUser->bind_param("isssssss", $ID, $fname, $lname, $email, $noPhone, $address, $cdCard, $pass);
            $addUser->execute();

            $_SESSION["userID"] = $ID;
            $_SESSION["fname"] = $fname;
            $_SESSION["lname"] = $lname;
            $_SESSION["isAdmin"] = 0;

            header("Location: index.php");
          }
          else {
            $err = "Dificultades técnicas, intente después";
            $allOK = false;
          }

        }
        else {
          $allOK = false;
        }
      }
      else {
        $err = "Dificultades técnicas, intente después";
        $allOK = false;
      }

    if (!$allOK) {

      header("Location: createAcc.php");
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>.error {color: red; font-size: smaller;}</style>

    <title>Crear cuenta | El Garage de Welsh</title>
  </head>
  <body>

    <div class="mb-1">
      <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="index.php">El Garage de Welsh</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
          <span class="navbar-toggler-icon"></span>
        </button>
      </nav>
    </div>

    <div class="container">
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-row">
          <div class="form-group col">
            <label for="fname">Nombre</label>
            <input type="text" class="form-control" id="fname" name="fname" placeholder="Primer nombre" required>
            <span class="error"><?php echo $fnameErr;?></span>
          </div>
          <div class="form-group col">
            <label for="lname">Apellido</label>
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Apellido" required>
            <span class="error"><?php echo $lnameErr;?></span>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="inputEmail">Correo electrónico</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Correo electrónico" required>
            <span class="error"><?php echo $emailErr;?></span>
          </div>
          <div class="form-group col">
            <label for="inputPassword">Contraseña</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Contraseña" required>
            <span class="error"><?php echo $passErr;?></span>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="address">Dirección</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Dirección">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="phone">Número de teléfono</label>
            <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890">
            <span class="error"><?php echo $noPhoneErr;?></span>
          </div>
          <div class="form-group col">
            <label for="creditCard">Tarjeta</label>
            <input type="text" class="form-control" id="creditCard" name="creditCard" pattern="[0-9]+" placeholder="Tarjeta">
            <span class="error"><?php echo $cdCardErr;?></span>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Crear cuenta</button>
        <span class="error"><?php echo $err?></span>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>