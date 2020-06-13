<?php
  session_start();

  if (!isset($_SESSION["userID"]) || !$_SESSION["isAdmin"]){
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
  
  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["incComp"]) && !empty($_POST["aumento"])) {
    if ($incComponente = $conn->prepare("UPDATE componentes
                                        SET Disponibilidad = (Disponibilidad + ?)
                                        WHERE ID_Componente = ?;")) {
      $incComponente->bind_param("ii", $_POST["aumento"], $_POST["incComp"]);
      $incComponente->execute();

      header("Location: component.php?comp=" .$_POST["incComp"]."");
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["nameComp"]) && !empty($_POST["precio"]) && !empty($_POST["disponible"]) && !empty($_POST["descripcion"])) {
    $ID = $nameComp = $precio = $disp = $descrip = null;
    
    $nameComp = test_input($_POST["nameComp"]);
    $precio = test_input($_POST["precio"]);
    $disp = test_input($_POST["disponible"]);
    $descrip = test_input($_POST["descripcion"]);
    if ($nextIDComp = $conn->prepare("SELECT max(ID_Componente) AS ID FROM componentes;")) {
      $nextIDComp->execute();

      $ID = 0;
      $result = $nextIDComp->get_result();
      if ($result->num_rows != 0) {
        $row = $result->fetch_assoc();
        $ID = $row["ID"] + 1;

        if ($addComp = $conn->prepare("INSERT INTO componentes (ID_Componente, Nombre, Descripcion, Precio, Disponibilidad, Fecha_de_creacion)
                                        VALUES (?, ?, ?, ?, ?, NOW());")) {
          $addComp->bind_param("issii", $ID, $nameComp, $descrip, $precio, $disp);
          $addComp->execute();

          // header("Location: myProjects.php");
          header("Location: component.php?comp=" .$ID."");
        }
      }
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

    <title>Panel de control | El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>

    <div class="container-fluid">
      <h2 class="card-title m-2">Panel de control | Componentes</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-row">
          <div class="form-group col">
            <label for="nameComp">Nombre</label>
            <input type="text" class="form-control" id="nameComp" name="nameComp" placeholder="Nombre de Componente" required>
          </div>
          <div class="form-group col">
            <label for="precio">Precio</label>
            <input type="number" id="precio" min="1" class="form-control" name="precio" placeholder="Precio" required>
          </div>
          <div class="form-group col">
            <label for="disponible">Disponible</label>
            <input type="number" id="disponible" min="1" class="form-control" name="disponible" placeholder="Disponible" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="descripcion">Descripcion</label>
            <textarea class="form-control" id="descripcion" rows="3" name="descripcion" placeholder="Aquí tu descripcion" max="254" required></textarea>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Crear nuevo proyecto</button>
      </form>
      <?php 
        echo '<div class="card"><div class="card-body">';
        echo '<h4 class="card-title">Incrementar disponibilidad</h4>';
        echo '<form action="'.$_SERVER["PHP_SELF"].'" method="post">
                <div class="form-group">
                  <label for="incComp">Agregar: </label>
                  <select class="form-control" id="incComp" name="incComp">';
        if ($optionsComp = $conn->prepare("SELECT ID_Componente, Nombre
                                          FROM componentes;")) {
          $optionsComp->execute();

          $result = $optionsComp->get_result();
          while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["ID_Componente"].'">'.$row["Nombre"].'</option>';
          }
        }
        echo  '   </select>
                </div>';
        echo '<div class="form-row">
                <div class="form-group col">
                    <input type="number" id="aumento" min="1" class="form-control" name="aumento" placeholder="Aumentar">
                </div>
                <div class="form-group col">
                  <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                </div>
              </div>';
        echo '</form>';
        echo '</div></div>';
      ?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>