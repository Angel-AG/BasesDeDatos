<?php 
  $compName = $mnPrice = $mxPrice = $stock = null;

  if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["compName"])) {
    $compName = explode(" ", test_input($_GET["compName"]));
    $mnPrice = !empty($_GET["minPrice"]) ? test_input($_GET["minPrice"]) : '';
    $mxPrice = !empty($_GET["maxPrice"]) ? test_input($_GET["maxPrice"]) : '';
    $stock = !empty($_GET["stock"]) ? test_input($_GET["stock"]) : '';
  }

?>
<h2>Componentes electrónicos</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
  <div class="form-row">
    <div class="form-group col">
      <input class="form-control mr-sm-2" type="search" id="compName" name="compName" placeholder="Buscar componentes...">
      <button class="btn btn-outline-primary mt-2 mr-2" type="submit">Buscar</button>
      <button class="btn btn-outline-info mt-2 mr-2" type="button" data-toggle="collapse" data-target="#opcionesComponentes" id="moreComp">Más opciones</button>
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
        <label for="stock">Solo en stock: </label>
        <input type="checkbox" class="form-control" id="stock" name="stock" disabled>
      </div>
    </div>
  </div>
</form>
  <?php
    if ($retrieveComp = $conn->prepare("SELECT comp.Nombre, comp.Descripcion, comp.Precio, count(favComp.Componente) AS TotalEstrellas
                                        FROM componentes AS comp
                                        LEFT JOIN componentes_favoritos AS favComp ON favComp.Componente = comp.ID_Componente
                                        GROUP BY comp.Nombre;")) {
      $retrieveComp->execute();

      $breakRow = 0;
      $result = $retrieveComp->get_result();
      while ($row = $result->fetch_assoc()) {
        if ($breakRow == 0) echo '<div class="card-deck">'; 

        echo '<div class="card mb-3"><div class="card-body">';
        echo '<h4 class="card-title">' .$row["Nombre"]. '</h4>';
        echo '<p class="card-text">' .$row["Descripcion"]. '.</p>';
        echo '<hr class="my-3">';
        echo '<div class="row">';
        echo '<div class="col-6"><h5 style="color: DarkGoldenRod;">Estrellas: ' .$row["TotalEstrellas"]. '</h5></div>';
        echo '<div class="col-3"><h5 style="color: green;">$' .$row["Precio"]. '</h5></div>';
        echo '<div class="col-3"><a class="btn btn-info btn-block" href="#" role="button">Detalles</a></div>';
        echo '</div>';
        echo '</div></div>';
        
        $breakRow = ($breakRow + 1);
        if ($breakRow == 3) echo '</div>';
        $breakRow = $breakRow % 3;
      }
    }
    else {
      $err = "Dificultades técnicas, intente después";
    } 
  ?>
</div>