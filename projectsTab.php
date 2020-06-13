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
<?php
    if ($retrieveComp = $conn->prepare("SELECT proy.Nombre, proy.Dificultad, count(favProy.Proyecto) AS TotalEstrellas, IFNULL(AVG(caliProy.Calificacion), 0) AS sumaCali
                                        FROM proyecto AS proy
                                        LEFT JOIN proyectos_favoritos AS favProy ON favProy.Proyecto = proy.ID_Proyecto
                                        LEFT JOIN calificaciones_proyectos AS caliProy ON caliProy.ID_Proyecto = proy.ID_Proyecto
                                        GROUP BY proy.ID_Proyecto;")) {
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