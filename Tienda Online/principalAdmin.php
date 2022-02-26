<?php
session_name('login');
session_start(); 
if(isset($_SESSION['login'])){
include("funciones.php");
cabecera();
}else {
  header("Location: index.php");
}
?>
<div class="container bg-dark mt-2">
<div class="row justify-content-center text-center text-white pt-3">
<div class="col-sm-12">
<div id="typed-strings">
     <h1>Bienvenido al panel de administrador</h1>
     <h1>¿Que desea hacer?</h1>
</div>
<h1 id="typed"></h1>
</div>
<div class="row justify-content-center align-items-center pt-5 pb-5 ">
  <div class="col-sm-6">
    <div class="card text-dark bg-white ">
      <div class="card-body">
        <h5 class="card-title">Asignar imágenes</h5>
        <p class="card-text">Permite subir y establecer la imagen de un producto.</p>
        <a href="asignar.php" class="btn btn-primary">Ir allí</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card text-dark bg-white">
      <div class="card-body">
        <h5 class="card-title">Listado Completo</h5>
        <p class="card-text">Muestra la lista completa con imagenes de todos los productos.</p>
        <a href="listado.php" class="btn btn-primary">Ir allí</a>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script>
var typed = new Typed('#typed',{
    stringsElement: '#typed-strings',         
});
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

