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
    <style>.error {color: red; font-size: smaller;}</style>
    <style>.exito {color: green;}</style>

    <title>Modificar datos | El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>
    <?php 
      // SQL HERE - SQL HERE - SQL HERE - SQL HERE - SQL HERE - SQL HERE -
      $fname = $lname = $address = $noPhone = $cdCard = $exito = "";
      $noPhoneErr = $cdCardErr = null;
      $allOK = false;

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // SQL HERE - SQL HERE - SQL HERE - SQL HERE - SQL HERE -
        $allOK = true;

        $address = !empty($_POST["address"]) ? test_input($_POST["address"]) : '';

        $noPhone = !empty($_POST["phone"]) ? test_input($_POST["phone"]) : '';
        if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $noPhone) && !empty($noPhone)) {
          $noPhoneErr = "Respetar patrón: 123-456-7890";
          $allOK = false;
          $exito = "error";
        }

        $cdCard = !empty($_POST["creditCard"]) ? test_input($_POST["creditCard"]) : '';
        if (!preg_match("/^[0-9]+$/", $cdCard) && !empty($cdCard)) {
          $cdCardErr= "Solamente números";
          $allOK = false;
          $exito = "error";
        }

      }

      if ($allOK) {
        // SQL HERE - SQL HERE - SQL HERE - SQL HERE - SQL HERE -
        $_SESSION["userID"] = 1;

        $exito = "exito";
      }
    ?>

    <div class="container">
    <h2 class="card-title">Modificar datos</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-row">
          <div class="form-group col">
            <label for="fname">Nombre</label>
            <input type="text" class="form-control" id="fname" placeholder="<?php echo $fname?>" disabled>
          </div>
          <div class="form-group col">
            <label for="lname">Apellido</label>
            <input type="text" class="form-control" id="lname" placeholder="<?php echo $lname?>" disabled>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="address">Dirección</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" value="<?php echo $address?>">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="phone">Número de teléfono</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="123-456-7890" value="<?php echo $noPhone?>">
            <span class="error"><?php echo $noPhoneErr;?></span>
          </div>
          <div class="form-group col">
            <label for="creditCard">Tarjeta</label>
            <input type="text" class="form-control" id="creditCard" name="creditCard" placeholder="Tarjeta" value="<?php echo $cdCard?>">
            <span class="error"><?php echo $cdCardErr;?></span>
          </div>
        </div>
        <button type="button" class="btn btn-danger btn-block" id="confirm">Confirmar información</button>
        <button type="submit" class="btn btn-primary btn-block" id="save" disabled>Guardar información</button>
      </form>
      <span class="<?php echo $exito?>" style="font-size: large !important;"><?php echo $exito?></span>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $('#confirm').click(function () {
        $('#confirm').prop('disabled', true);
        $('#save').prop('disabled', false);
      });
    </script>
  </body>
</html>