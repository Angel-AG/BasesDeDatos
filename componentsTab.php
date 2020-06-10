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