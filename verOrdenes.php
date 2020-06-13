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
      <h2 class="card-title m-2">Panel de control | Ventas</h2>
      <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Email</th>
            <th scope="col">Tarjeta</th>
            <th scope="col">Fecha de compra</th>
            <th scope="col">Total</th>
          </tr>
        </thead>
        <tbody>
        <?php 
          if ($salesReport = $conn->prepare("SELECT o.No_orden, us.Nombre, us. Apellido, us.E_mail, us.Tarjeta, o.Fecha_de_compra, sum(deta.Cantidad * comp.Precio) as Total
                                              FROM orden AS o
                                              JOIN usuario AS us ON us.ID_Usuario = o.Comprador
                                              JOIN detalles_de_orden AS deta ON deta.No_de_orden = o.No_orden
                                              JOIN componentes AS comp ON comp.ID_Componente = deta.Componente
                                              GROUP BY o.No_orden;")) {
            $salesReport->execute();

            $result = $salesReport->get_result();
            while ($row = $result->fetch_assoc()) {
              echo '<tr>';
              echo '<th scope="row">' .$row["No_orden"]. '</th>';
              echo '<td>' .$row["Nombre"]. '</td>';
              echo '<td>' .$row["Apellido"]. '</td>';
              echo '<td>' .$row["E_mail"]. '</td>';
              echo '<td>' .$row["Tarjeta"]. '</td>';
              echo '<td>' .$row["Fecha_de_compra"]. '</td>';
              echo '<td>$' .$row["Total"]. '</td>';
              echo '</tr>';
            }
          }
        ?>
        </tbody>
      </table>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>