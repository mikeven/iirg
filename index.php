<?php
	/*
	 * R&G - Inicio de sesión
	 * 
	 */
	session_start();
	ini_set( 'display_errors', 1 );
	include( "bd/data-usuario.php" );
	checkSession( 'index' );
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IIRG | Ingreso</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="css/ionicons.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
    <link rel="stylesheet" type="text/css" href="plugins/bootstrapvalidator-dist-0.5.3/dist/css/bootstrapValidator.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/fn-usuario.js"></script>
    <style>
    .login-box{ margin: 7% auto 1% auto; }
    .register-box{ margin: 1% auto; }
    .login-box-msg{ font-size: 18px; }
    #waitconfirm{ width: 100% !important; margin: 50px auto 0 auto; }
    </style>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a><b>R&G</b> Facturación</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Ingreso al sistema</p>
        <form id="loginform">
          <input name="login" type="hidden" value="1"/>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Usuario" name="usuario">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Contraseña" name="passw">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <!--<div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>-->
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="button" class="btn btn-primary btn-block btn-flat" onClick="log_in()">Entrar</button>
            </div><!-- /.col -->
          </div>
        </form>
        <div id="response"></div>
        <!--<a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>-->

      </div><!-- /.login-box-body -->


    </div><!-- /.login-box -->

    <div class="register-box hidden">
      <div class="login-box-body">
        <p class="login-box-msg"><a href="#!" id="breguser"><i class="fa fa-database"></i> Registrar nuevo usuario</a></p>
        <div id="dformreg">
            <form id="regform">
              <input name="registro" type="hidden" value="1"/>
              <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Usuario" name="rusuario">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" data-minlength="6" placeholder="Contraseña" name="rpassw1" id="psw1">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Confirme contraseña" name="rpassw2" data-match="#psw1">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-8">
                </div><!-- /.col -->
                <div class="col-xs-4">
                  <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                </div><!-- /.col -->
              </div>
            </form>
          </div>
        <?php include("sub-scripts/nav/mensaje_rcpf.php");?>
        <div id="rreg"></div>
        <!--<a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script src="plugins/bootstrapvalidator-dist-0.5.3/dist/js/bootstrapValidator.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
        
        $("#dformreg").hide(); $(".alert").hide();
        $("#breguser").click(function(){
          $("#dformreg").toggle(200);
        });

        $('#regform').bootstrapValidator({
            message: 'Revise el contenido del campo',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                rusuario: {
                    validators: { notEmpty: { message: 'Debe indicar nombre de usuario' } }
                },
                rpassw1: {
                    validators: { notEmpty: { message: 'Debe indicar constraseña' } }
                },
                rpassw2:{
                    validators: { 
                      identical: {
                        field: 'rpassw1',
                        message: 'Las contraseñas deben coincidir'
                      }
                    }
                }
            },
            onSuccess: function(e, data) {
              e.preventDefault();
              registroU();
            }
        });

      });
    </script>
  </body>
</html>
