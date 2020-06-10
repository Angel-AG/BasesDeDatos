<?php
  session_start();

  if (!isset($_SESSION["userID"])){
    $_SESSION["userID"] = null;
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

    <div class="container-fluid">
      <ul class="nav nav-tabs nav-fill justify-content-center" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="componentes-tab" data-toggle="tab" href="#componentes" role="tab">Componentes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="proyectos-tab" data-toggle="tab" href="#proyectos" role="tab">Proyectos</a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="componentes" role="tabpanel">
          <?php include 'componentsTab.php';?>
        </div>
        <div class="tab-pane fade" id="proyectos" role="tabpanel">
          <?php include 'projectsTab.php';?>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $('#opcionesComponentes').on('show.bs.collapse', function () {
        $('#minPrice').prop('disabled', false);
        $('#maxPrice').prop('disabled', false);
        $('#stock').prop('disabled', false);
      });

      $('#opcionesComponentes').on('hide.bs.collapse', function () {
        $('#minPrice').prop('disabled', true);
        $('#maxPrice').prop('disabled', true);
        $('#stock').prop('disabled', true);
      });
    </script>
    <script type="text/javascript">
      $('#opcionesProyectos').on('show.bs.collapse', function () {
        $('#authorFName').prop('disabled', false);
        $('#authorLName').prop('disabled', false);
        $('#difficulty').prop('disabled', false);
      });

      $('#opcionesProyectos').on('hide.bs.collapse', function () {
        $('#authorFName').prop('disabled', true);
        $('#authorLName').prop('disabled', true);
        $('#difficulty').prop('disabled', true);
      });
    </script>
  </body>
</html>