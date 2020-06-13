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

    <?php
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
          echo '<p class="card-text '.$row["Dificultad"].'">' .$row["Dificultad"]. '.</p>';
          echo '<hr class="my-3">';
          echo '<div class="row">';
          echo '<div class="col-4"><h5 style="color: GoldenRod;">Estrellas: ' .$row["TotalEstrellas"]. '</h5></div>';
          if ($row["sumaCali"]) echo '<div class="col-5"><h5>Sin calificación</h5></div>';
          else echo '<div class="col-5"><h5>Calificación general: $' .$row["sumaCali"]. '</h5></div>';
          echo '<div class="col-3"><a class="btn btn-info btn-block" href="#" role="button">Detalles</a></div>';
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
    ?>

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
              echo '<p class="card-text '.$row["Dificultad"].'">' .$row["Dificultad"]. '.</p>';
              echo '<hr class="my-3">';
              echo '<div class="row">';
              echo '<div class="col-4"><h5 style="color: GoldenRod;">Estrellas: ' .$row["TotalEstrellas"]. '</h5></div>';
              if ($row["sumaCali"]) echo '<div class="col-5"><h5>Sin calificación</h5></div>';
              else echo '<div class="col-5"><h5>Calificación general: $' .$row["sumaCali"]. '</h5></div>';
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