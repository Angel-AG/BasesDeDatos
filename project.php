<?php
  session_start();

  if (!isset($_SESSION["userID"])){
    $_SESSION["userID"] = null;
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
  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["addComp"]) && !empty($_POST["quantity"])) {
    $IDProy = test_input($_GET["proy"]);
    $IDComp = test_input($_POST["addComp"]);
    $Qty = test_input($_POST["quantity"]);
    if ($insertComp = $conn->prepare("INSERT INTO proyecto_componente (Proyecto, Componente, Cantidad)
                                      VALUES (?, ?, ?);")) {
      $insertComp->bind_param("iii", $IDProy, $IDComp, $Qty);
      $insertComp->execute();

      header("Location: project.php?proy=" .$IDProy. "");
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["fav"])) {
    $IDProy = test_input($_GET["proy"]);
    if ($insertComp = $conn->prepare("INSERT INTO proyectos_favoritos (Proyecto, Usuario)
                                      VALUES (?, ?);")) {
      $insertComp->bind_param("ii", $IDProy, $_SESSION["userID"]);
      $insertComp->execute();

      header("Location: project.php?proy=" .$IDProy. "");
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["calif"])) {
    $IDProy = test_input($_GET["proy"]);
    $Calif = test_input($_POST["calif"]);
    if ($insertComp = $conn->prepare("INSERT INTO calificaciones_proyectos (ID_Proyecto, ID_Usuario, Calificacion) 
                                      VALUES (?, ?, ?);")) {
      $insertComp->bind_param("iii", $IDProy, $_SESSION["userID"], $Calif);
      $insertComp->execute();

      header("Location: project.php?proy=" .$IDProy. "");
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
    <style>
      .error {color: red; font-size: smaller;}
      .Principiante {color: green;}
      .Intermedio {color: DarkGoldenRod;}
      .Avanzado {color: red;}
    </style>

    <title>El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>

    <div class="container-fluid">
      <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["proy"])) {
          $IDProy = test_input($_GET["proy"]);
          if ($retrieveComp = $conn->prepare("SELECT proy.Nombre, us.Nombre AS userName, us.Apellido, proy.Fecha_de_creacion, proy.Dificultad, proy.Descripcion, count(favProy.Proyecto) AS TotalEstrellas, IFNULL(AVG(caliProy.Calificacion), 0) AS sumaCali
                                              FROM proyecto AS proy
                                              LEFT JOIN proyectos_favoritos AS favProy ON favProy.Proyecto = proy.ID_Proyecto
                                              LEFT JOIN calificaciones_proyectos AS caliProy ON caliProy.ID_Proyecto = proy.ID_Proyecto
                                              JOIN usuario AS us ON us.ID_Usuario = proy.Autor
                                              WHERE proy.ID_Proyecto = ?
                                              GROUP BY proy.ID_Proyecto;")) {
            $retrieveComp->bind_param("i", $IDProy);
            $retrieveComp->execute();

            $breakRow = 0;
            $result = $retrieveComp->get_result();
            while ($row = $result->fetch_assoc()) {
              if ($breakRow == 0) echo '<div class="card-deck">'; 

              echo '<div class="card mb-3"><div class="card-body">';
              echo '<h4 class="card-title">' .$row["Nombre"]. '</h4>';
              echo '<p class="card-text">De: ' .$row["userName"]. ' ' .$row["Apellido"]. ' | Creado el ' .$row["Fecha_de_creacion"]. '</p>';
              echo '<p class="lead">' .$row["Descripcion"].'</p>';
              echo '<hr class="my-3">';
              echo '<div class="row">';
              echo '<div class="col-4"><h5 style="color: GoldenRod;">Estrellas: ' .$row["TotalEstrellas"]. '</h5></div>';
              if ($row["sumaCali"] == 0) echo '<div class="col-5"><h5>Sin calificación</h5></div>';
              else echo '<div class="col-5"><h5>Calificación general: ' .$row["sumaCali"]. '</h5></div>';
              echo '<div class="col-3"><h5  class="card-text '.$row["Dificultad"].'">' .$row["Dificultad"]. '</h5></div>';
              echo '</div>';
              echo '</div></div>';
              
              $breakRow = ($breakRow + 1);
              if ($breakRow == 3) echo '</div>';
              $breakRow = $breakRow % 3;
            }
            if ($breakRow != 0) echo '</div>';
          }
          else {
            $err = "Dificultades técnicas, intente después";
          }

          // Lista de componentes
          if ($retrieveComp = $conn->prepare("SELECT comp.Nombre, proyComp.Cantidad
                                              FROM proyecto_componente AS proyComp
                                              JOIN componentes AS comp ON comp.ID_Componente = proyComp.Componente
                                              WHERE proyComp.Proyecto = ?;")) {
            $retrieveComp->bind_param("i", $IDProy);
            $retrieveComp->execute();

            echo "<h3>Lista de componentes</h3>";
            $breakRow = 0;
            $result = $retrieveComp->get_result();
            while ($row = $result->fetch_assoc()) {
              if ($breakRow == 0) echo '<div class="card-deck">'; 

              echo '<div class="card mb-3"><div class="card-body">';
              echo '<div class="row">';
              echo '<div class="col-10"><h5>' .$row["Nombre"]. '</h5></div>';
              echo '<div class="col-2"><h5>x' .$row["Cantidad"]. '</h5></div>';
              echo '</div>';
              echo '</div></div>';
              
              $breakRow = ($breakRow + 1);
              if ($breakRow == 3) echo '</div>';
              $breakRow = $breakRow % 3;
            }
            if ($breakRow != 0) echo '</div>';
          }
          else {
            $err = "Dificultades técnicas, intente después";
          }
          
          // Sesión iniciada
          if (isset($_SESSION["userID"]) && 
              $retrieveComp = $conn->prepare("SELECT Autor 
                                              FROM proyecto 
                                              WHERE ID_Proyecto = ? AND Autor = ?;")) {
            $retrieveComp->bind_param("ii", $IDProy, $_SESSION["userID"]);
            $retrieveComp->execute();

            $result = $retrieveComp->get_result();
            if ($result->num_rows == 1) {
              echo '<div class="card"><div class="card-body">';
              echo '<h4 class="card-title">Agregar componentes a tu proyecto</h4>';
              echo '<form action="' .$_SERVER["PHP_SELF"]. '?proy='.$_GET["proy"].'" method="post">
                      <div class="form-group">
                        <label for="addComp">Agregar: </label>
                        <select class="form-control" id="addComp" name="addComp">';
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
                          <input type="number" id="quantity" min="1" class="form-control" name="quantity" placeholder="Cantidad">
                      </div>
                      <div class="form-group col">
                        <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                      </div>
                    </div>';
              echo '</form>';
              echo '</div></div>';
            }
            else {
              echo '<div class="card"><div class="card-body"><div class="row">';
              echo '<div class="col"><form action="' .$_SERVER["PHP_SELF"]. '?proy='.$_GET["proy"].'" method="post">
                      <div class="form-group">
                        <button type="submit" name="fav" value="'.$IDProy.'" class="btn btn-primary btn-primary btn-block">Agregar a favoritos</button>
                      </div></form></div>';
              echo '<div class="col"><form action="' .$_SERVER["PHP_SELF"]. '?proy='.$_GET["proy"].'" method="post"><div class="form-row">
                      <div class="form-group col">
                          <input type="number" id="calif" min="0" max="10" class="form-control" name="calif" placeholder="Calificacion: 0 - 10">
                      </div>
                      <div class="form-group col">
                        <button type="submit" class="btn btn-primary btn-info btn-block">Calificar</button>
                      </div></div></form></div>';
              echo '</div></div></div>';
              // if ($optionsComp = $conn->prepare("SELECT ID_Componente, Nombre
              //                                   FROM componentes;")) {
              //   $optionsComp->execute();

              //   $result = $optionsComp->get_result();
              //   while ($row = $result->fetch_assoc()) {
              //     echo '<option value="'.$row["ID_Componente"].'">'.$row["Nombre"].'</option>';
              //   }
              // }
//               INSERT INTO proyectos_favoritos (Proyecto, Usuario)
// VALUES (3, 55);
            }
          }
        }
      ?>
    </div>

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>