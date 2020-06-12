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
  $proyecto = null;

  if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["byeProy"])) {
    $proyecto = test_input($_GET["byeProy"]);
  }

  if (isset($proyecto)) {
    if ($delComp = $conn->prepare("DELETE FROM proyectos_favoritos
                                  WHERE Proyecto = ? AND Usuario = ?;")) {
      $delComp->bind_param("ii", $proyecto, $_SESSION["userID"]);
      $delComp->execute();

      header("Location: ".$_SERVER["PHP_SELF"]."");
    }
    else {
      $err = "Dificultades técnicas, intente después";
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
      .Principiante {color: green;}
      .Intermedio {color: DarkGoldenRod;}
      .Avanzado {color: red;}
    </style>

    <title>El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>
    
    <div class="container">
      <h2 class="card-title">Proyectos favoritos</h2>
      <?php
        if ($retrieveProy = $conn->prepare("SELECT proy.ID_Proyecto, proy.Nombre, proy.Dificultad
                                            FROM proyectos_favoritos AS favProy
                                            JOIN proyecto AS proy ON proy.ID_Proyecto = favProy.Proyecto
                                            WHERE favProy.Usuario = ?;")) {
          $retrieveProy->bind_param("i", $_SESSION["userID"]);
          $retrieveProy->execute();

          $breakRow = 0;
          $result = $retrieveProy->get_result();
          while ($row = $result->fetch_assoc()) {
            if ($breakRow == 0) echo '<div class="card-deck">';

            echo '<div class="card mb-3"><div class="card-body">';
            echo '<h4 class="card-title">' .$row["Nombre"]. '</h4>';
            echo '<hr class="my-3">';
            echo '<div class="row">';
            echo '<div class="col-3"><h5 class="'.$row["Dificultad"].'">' .$row["Dificultad"]. '</h5></div>';
            echo '<div class="col-3"><form action="' .$_SERVER["PHP_SELF"]. '" method="get"><button name="byeProy" value="'.$row["ID_Proyecto"].'" class="btn btn-danger btn-block btn-block" type="submit">Quitar</button></form></div>';
            echo '<div class="col-6"><a class="btn btn-info btn-block" href="#" role="button">Ver detalles</a></div>';
            echo '</div>';
            echo '</div></div>';
            
            $breakRow = ($breakRow + 1);
            if ($breakRow == 2) echo '</div>';
            $breakRow = $breakRow % 2;
          }
        }
        else {
          $err = "Dificultades técnicas, intente después";
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