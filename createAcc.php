<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Crear cuenta | El Garage de Welsh</title>
  </head>
  <body>

    <?php include 'topNavbar.php';?>

    <div class="container">
      <form>
        <div class="form-row">
          <div class="form-group col">
            <label for="fname">Nombre</label>
            <input type="text" class="form-control" id="fname" name="fname" placeholder="Primer nombre" required>
          </div>
          <div class="form-group col">
            <label for="lname">Apellido</label>
            <input type="text" class="form-control" id="lname" name="lname" placeholder="Apellido" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col">
            <label for="inputEmail">Correo electrónico</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Correo electrónico" required>
          </div>
          <div class="form-group col">
            <label for="inputPassword">Contraseña</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Contraseña" required>
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
            <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="123-45-678">
          </div>
          <div class="form-group col">
            <label for="creditCard">Tarjeta</label>
            <input type="text" class="form-control" id="creditCard" name="creditCard" placeholder="Tarjeta">
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Crear cuenta</button>
      </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>