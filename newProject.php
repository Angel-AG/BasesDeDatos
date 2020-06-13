<?php
  session_start();

  if (!isset($_SESSION["userID"])){
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
  $ID = $nameProy = $dif = $descrip = null;
  $nameProyErr = $descripErr = null;
  $allOK = false;

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["dificultad"])) {
    $allOK = true;

    $nameProy = !empty($_POST["nameProy"]) ? test_input($_POST["nameProy"]) : '';
    if (empty($_POST["nameProy"])) {
      $nameProyErr = "Ingresa nombre";
      $allOK = false;
    }
 
    if ($_POST["dificultad"] == "Principiante" || $_POST["dificultad"] == "Intermedio" || $_POST["dificultad"] == "Avanzado") {
      $dif = $_POST["dificultad"];
    }
    else {
      $allOK = false;
    }

    $descrip = !empty($_POST["descripcion"]) ? test_input($_POST["descripcion"]) : '';
    if (empty($_POST["descripcion"])) {
      $descripErr = "Ingresa descripcion";
      $allOK = false;
    }
  }

  if ($allOK) {
    if ($nextIDProy = $conn->prepare("SELECT max(ID_Proyecto) AS ID FROM proyecto;")) {
      $nextIDProy->execute();

      $ID = 0;
      $result = $nextIDProy->get_result();
      if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $ID = $row["ID"] + 1;

        if ($addProy = $conn->prepare("INSERT INTO proyecto (ID_Proyecto, Nombre, Autor, Fecha_de_creacion, Dificultad, Descripcion)
                                        VALUES (?, ?, ?, NOW(), ?, ?);")) {
          $addProy->bind_param("isiss", $ID, $nameProy, $_SESSION["userID"], $dif, $descrip);
          $addProy->execute();

          header("Location: myProjects.php");
          // header("Location: proyecto.php?proy=" .$ID."");
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
      // header("Location: newProject.php");
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

    <title>El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>

    <div class="container">
      <h2 class="card-title">Nuevo proyecto</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-row">
          <div class="form-group col">
            <label for="nameProy">Nombre</label>
            <input type="text" class="form-control" id="nameProy" name="nameProy" placeholder="Nombre de proyecto" required>
            <span class="error"><?php echo $nameProyErr;?></span>
          </div>
          <div class="form-group col">
            <label for="dificultad">Dificultad</label>
            <select class="form-control" id="dificultad" name="dificultad" required>
              <option value="Principiante">Principiante</option>
              <option value="Intermedio">Intermedio</option>
              <option value="Avanzado">Avanzado</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="descripcion">Descripcion</label>
            <textarea class="form-control" id="descripcion" rows="3" name="descripcion" placeholder="Aquí tu descripcion" max="254" required></textarea>
          </div>
          <span class="error"><?php echo $descripErr;?></span>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Crear nuevo proyecto</button>
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