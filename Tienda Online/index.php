<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Introduce tu usuario y tu contraseña</p>
                <p class="error" id="error" style="display:none"></p>
              <form action="index.php" method="post" id="frmLogin" name="frmLogin">
              <div class="form-outline form-white mb-4">
                <input type="text" id="txtUsuario" name="txtUsuario" class="form-control form-control-lg"  placeholder="Usuario"/>
              </div>

              <div class="form-outline form-white mb-4">
                <input type="password" id="txtContraseña" name="txtContraseña" class="form-control form-control-lg" placeholder="Contraseña" />
              </div>


              <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function mostrarError(txtMostrar){
    document.getElementById('error').innerHTML = txtMostrar;
    document.getElementById('error').style.display="block";
}
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

<?php
session_name('login');
session_start();
include("funcionesBD.php");
$conexion=mysqli_connect("localhost","root","","pedidos");
if(isset($_POST['txtUsuario']) && isset($_POST['txtContraseña'])){
    $usuario=$_POST['txtUsuario'];
    $contraseña=$_POST['txtContraseña'];
    switch(comprobarUsuario("clientes","EMAIL","PASSWORD",$usuario,$contraseña)){
        case 0:
            require_once 'bd.php';
            $usu=comprobar_usuario($usuario,$contraseña);
            $_SESSION['login']=true;
            $_SESSION['usuario']=$usu;
            $sql="SELECT tipo FROM clientes WHERE email ='".$usuario."'";
            $res=mysqli_query($conexion,$sql);
            $res=mysqli_fetch_array($res);
            if($res[0]=="admin"){
              $_SESSION['tipo']="admin";
               header("Location: principalAdmin.php");
             }else {
              header("Location: principalTienda.php");
             }
           
            break;
        case 1:
            echo "<script>mostrarError('Contraseña incorrecta')</script>";
            break;
        case 2:
            echo "<script>mostrarError('El usuario no existe')</script>";
            break;
        case 3:
            echo "<script>mostrarError('Debes rellenar ambos campos')</script>";
            break;
        case 4:
            break;
        default:
            break;
    }
}
?>