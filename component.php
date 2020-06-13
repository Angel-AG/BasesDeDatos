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
  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["fav"])) {
    $IDComp = test_input($_GET["comp"]);
    if ($insertComp = $conn->prepare("INSERT INTO componentes_favoritos (Componente, Usuario)
                                      VALUES (?, ?);")) {
      $insertComp->bind_param("ii", $IDComp, $_SESSION["userID"]);
      $insertComp->execute();

      header("Location: component.php?comp=" .$IDComp. "");
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["compra"])) {
    $IDComp = test_input($_GET["comp"]);
    $Qty = test_input($_POST["compra"]);
    $IDOrden = null;
    if ($buyComp = $conn->prepare("SELECT Tarjeta FROM usuario WHERE ID_Usuario = ?;")) {
      $buyComp->bind_param("i", $_SESSION["userID"]);
      $buyComp->execute();

      $card = null;
      $result = $buyComp->get_result();
      if ($row = $result->fetch_assoc()) $card = $row["Tarjeta"];
      
      if (!empty($card) && $buyComp = $conn->prepare("SELECT IFNULL(max(No_orden), 1) AS mx FROM orden;")) {
        $buyComp->execute();
        $result = $buyComp->get_result();
        if ($row = $result->fetch_assoc()) $IDOrden = $row["mx"] + 1;
      }
    }

    if (isset($IDOrden) && $buyComp = $conn->prepare("INSERT INTO orden (No_orden, Comprador, Fecha_de_compra)
                                                      VALUES (?, ?, NOW());")) {
      $buyComp->bind_param("ii", $IDOrden, $_SESSION["userID"]);
      $buyComp->execute();
      if ($buyComp = $conn->prepare("INSERT INTO detalles_de_orden (No_de_orden, Componente, Cantidad) 
                                      VALUES (?, ?, ?);")) {
        $buyComp->bind_param("iii", $IDOrden, $IDComp, $Qty);
        $buyComp->execute();
        if ($buyComp = $conn->prepare("UPDATE componentes
                                      SET Disponibilidad = (Disponibilidad - ?)
                                      WHERE ID_Componente = ?;")) {
          $buyComp->bind_param("ii", $Qty, $IDComp);
          $buyComp->execute();

          header("Location: component.php?comp=" .$IDComp. "");
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
        if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["comp"])) {
          $IDComp = test_input($_GET["comp"]);
          if ($retrieveComp = $conn->prepare("SELECT comp.Nombre, comp.Descripcion, comp.Precio, comp.Disponibilidad, count(favComp.Componente) AS TotalEstrellas
                                              FROM componentes AS comp
                                              LEFT JOIN componentes_favoritos AS favComp ON favComp.Componente = comp.ID_Componente
                                              WHERE comp.ID_Componente = ?
                                              GROUP BY comp.ID_Componente;")) {
            $retrieveComp->bind_param("i", $IDComp);
            $retrieveComp->execute();

            $breakRow = 0;
            $result = $retrieveComp->get_result();
            if ($row = $result->fetch_assoc()) {
              if ($breakRow == 0) echo '<div class="card-deck">'; 

              echo '<div class="card mb-3"><div class="card-body">';
              echo '<h4 class="card-title">' .$row["Nombre"]. '</h4>';
              echo '<p class="lead">' .$row["Descripcion"].'</p>';
              echo '<hr class="my-3">';
              echo '<div class="row">';
              echo '<div class="col-6"><h5 style="color: GoldenRod;">Estrellas: ' .$row["TotalEstrellas"]. '</h5></div>';
              echo '<div class="col-3"><h5 style="color: green;">$' .$row["Precio"]. '</h5></div>';
              echo '<div class="col-3"><h5>Disponibles: ' .$row["Disponibilidad"]. '</h5></div>';
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
          if (isset($_SESSION["userID"])) {
            echo '<div class="card"><div class="card-body"><div class="row">';
            echo '<div class="col"><form action="' .$_SERVER["PHP_SELF"]. '?comp='.$_GET["comp"].'" method="post">
                    <div class="form-group">
                      <button type="submit" name="fav" value="'.$IDComp.'" class="btn btn-primary btn-primary btn-block">Agregar a favoritos</button>
                    </div></form></div>';
            echo '<div class="col"><form action="' .$_SERVER["PHP_SELF"]. '?comp='.$_GET["comp"].'" method="post"><div class="form-row">
                    <div class="form-group col">
                        <input type="number" id="compra" min="0" max="'.$row["Disponibilidad"].'" class="form-control" name="compra" placeholder="Comprar">
                    </div>
                    <div class="form-group col">
                      <button type="submit" class="btn btn-primary btn-info btn-block">Comprar</button>
                    </div></div></form></div>';
            echo '</div></div></div>';
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