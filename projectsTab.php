<?php 
  $projectName = $authorFName = $authorLName = $difficulty = null;

  if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET["projectName"])) {
    $projectName = explode(" ", test_input($_GET["projectName"]));
    $authorFName = !empty($_GET["authorFName"]) ? test_input($_GET["authorFName"]) : '';
    $authorLName = !empty($_GET["authorLName"]) ? test_input($_GET["authorLName"]) : '';
    $difficulty = !empty($_GET["difficulty"]) ? test_input($_GET["difficulty"]) : '';
  }

?>
<h2>Proyectos</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
  <div class="form-row">
    <div class="form-group col">
      <input class="form-control mr-sm-2" type="search" id="projectName" name="projectName" placeholder="Buscar proyectos...">
      <button class="btn btn-outline-primary mt-2 mr-2" type="submit">Buscar</button>
      <button class="btn btn-outline-info mt-2 mr-2" type="button" data-toggle="collapse" data-target="#opcionesProyectos">Más opciones</button>
    </div>
  </div>
  <div class="collapse" id="opcionesProyectos">
    <div class="form-row">
      <div class="form-group col">
        <label for="authorFName">Nombre del autor: </label>
        <input type="text" class="form-control" id="authorFName" name="authorFName" placeholder="Primer nombre" disabled>
      </div>
      <div class="form-group col">
        <label for="authorLName">Apellido del autor: </label>
        <input type="text" class="form-control" id="authorLName" name="authorLName" placeholder="Apellido" disabled>
      </div>
      <div class="form-group col">
        <label for="difficulty">Dificultad: <br></label>
        <select class="custom-select" id="difficulty" name="difficulty" disabled>
          <option value="0" selected>Cualquiera</option>
          <option value="1">Principiante</option>
          <option value="2">Intermedio</option>
          <option value="3">Avanzado</option>
        </select>
      </div>
    </div>
  </div>
</form>