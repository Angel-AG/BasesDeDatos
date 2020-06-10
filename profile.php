<?php
  session_start();

  if (!isset($_SESSION["userID"])){
    header("Location: index.php");
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

    <title>Tu Garage | El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>

    <div class="container-fluid">
      <h2 class="card-title m-2">Mi Garage</h2>
      <div class="row m-2">
        <div class="col">
        <a class="btn btn-primary btn-lg btn-block" href="myComponentes.php" role="button">Mis componentes</a>
        </div>
        <div class="col">
          <a class="btn btn-primary btn-lg btn-block" href="myProject.php" role="button">Mis proyectos</a>
        </div>
      </div>
      <div class="row m-2">
        <div class="col">
          <a class="btn btn-dark btn-lg btn-block" href="modMyData.php" role="button">Modificar datos personales</a>
        </div>
        <div class="col">
          <a class="btn btn-dark btn-lg btn-block" href="newProject.php" role="button">Nuevo proyecto</a>
        </div>
      </div>
      <?php
        // IF ADMIN - IF ADMIN - IF ADMIN - IF ADMIN - IF ADMIN 
        if (true) {
          echo '<div class="row m-2">
                  <div class="col">
                    <a class="btn btn-info btn-lg btn-block" href="controlPanel.php" role="button">Panel de Control</a>
                  </div>
                </div>';
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