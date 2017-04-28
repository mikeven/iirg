<?php 
  $usuario = obtenerUsuarioPorId( $_SESSION["user"]["idUsuario"], $dbh );
?>
<li class="dropdown user user-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
  <span class="hidden-xs"><?php echo $usuario["nombre"]; ?></span>
</a>
<ul class="dropdown-menu">
  <!-- User image -->
  <li class="user-header">
    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    <p>
      <?php echo $usuario["nombre"]; ?>
      <small><?php echo $usuario["usuario"]; ?></small>
    </p>
  </li>
  <!-- Menu Body -->
  <input type="hidden" name="idusuario_sesion" id="idu_sesion" value="<?php echo $usuario["idUsuario"]; ?>">
  <li class="user-body">
    <div class="row">
      <div align="center"><h4><?php echo $usuario["empresa"]; ?></h3></div> 
    </div>
    <!-- /.row -->
  </li>
  <!-- Menu Footer-->
  <li class="user-footer">
    <div class="pull-left">
      <a href="cuenta.php" class="btn btn-default btn-flat">Datos de cuenta</a>
    </div>
    <div class="pull-right">
      <a href="index.php?logout" class="btn btn-default btn-flat">Salir</a>
    </div>
  </li>
</ul>
</li>