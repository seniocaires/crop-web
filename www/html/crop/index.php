<?php include 'filesLogic.php';?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="style.css">
    <title>Files Upload and Download</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Arquivo</h3>
          <input type="file" name="myfile"> <br/>
          <h3>Número de partes</h3>
          <input type="number" min="1" max="20" name="parts_size" value="10"> <br/>
          <h3>Posição inicial do corte</h3>
          <select name="position">
            <option value="0">Topo-Esquerda</option>
            <option value="1">Topo-Direita</option>
            <option value="2">Baixo-Esquerda</option>
            <option value="3">Baixo-Direita</option>
          </select> <br/><br/>
          <button type="submit" name="save">upload</button>
        </form>
      </div>
    </div>
  </body>
</html>