<li class="dropdown user user-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
  <span class="hidden-xs"><?php echo $_SESSION["user"]["nombre"]; ?></span>
</a>
<ul class="dropdown-menu">
  <!-- User image -->
  <li class="user-header">
    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
    <p>
      <?php echo $_SESSION["user"]["nombre"]; ?>
      <small>Member since Nov. 2012</small>
    </p>
  </li>
  <!-- Menu Body -->
  <!--<li class="user-body">
    <div class="row">
      <div class="col-xs-4 text-center">
        <a href="#">Followers</a>
      </div>
      <div class="col-xs-4 text-center">
        <a href="#">Sales</a>
      </div>
      <div class="col-xs-4 text-center">
        <a href="#">Friends</a>
      </div>
    </div>-->
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