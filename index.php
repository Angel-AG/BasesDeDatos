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
          <h2>Componentes electrónicos</h2>
          <form>
            <div class="form-row">
              <div class="form-group col">
                <input class="form-control mr-sm-2" type="search" id="nombreComp" name="nombreComp" placeholder="Buscar componentes...">
                <button class="btn btn-outline-primary mt-2 mr-2" type="submit">Buscar</button>
                <button class="btn btn-outline-info mt-2 mr-2" type="button" data-toggle="collapse" data-target="#opcionesComponentes">Más opciones</button>
              </div>
            </div>
            <div class="collapse" id="opcionesComponentes">
              <div class="form-row">
                <div class="form-group col">
                  <label for="minPrice">Precio Minimo: </label>
                  <input type="number" class="form-control" id="minPrice" name="minPrice" min="0" disabled>
                </div>
                <div class="form-group col">
                  <label for="minPrice">Precio Máximo: </label>
                  <input type="number" class="form-control" id="maxPrice" name="maxPrice" max="15000" disabled>
                </div>
                <div class="form-group col">
                  <label for="stock">En stock: </label>
                  <input type="checkbox" class="form-control" id="stock" name="stock" disabled>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane fade" id="proyectos" role="tabpanel">
          <h2>Proyectos</h2>
          <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar proyectos...">
            <button class="btn btn-outline-primary mr-2" type="submit">Buscar</button>
            <button class="btn btn-outline-info mr-2" type="submit">Búsqueda avanzada</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>