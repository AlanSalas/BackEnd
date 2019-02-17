<!DOCTYPE html>
<html>
<head>
	<title></title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body class="text-center">
<form class="form-signin">
  <img class="mb-4" src="img/logotipo.png" alt="activebox">
  <h1 class="h3 mb-3 font-weight-normal">Iniciar Sesión</h1>
  <label for="inputEmail" class="sr-only">Correo Electronico</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
  <label for="inputPassword" class="sr-only">Contraseña</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Recuerdame
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="button" id="buttonSign">Iniciar</button>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
	<script>
		//$().(); SINTAXIS BASICA JQUERY
		//Pesitos = alias manda a llamar una clase, Usar jQuery cuando estemos utilizando un framework distinto
		//Primer parentesis siempre llevará selectores casi todos llevaran "" excepto unos selectores como document
		//Segundo parentesis llevará el evento se puede llamar una funcion anonima dentro del evento
		//Selector, evento, funcion
		$("#buttonSign").click(function(){
			// 1. Obtener el valor del email
			let correo = $("#inputEmail").val();
			// 2. Obtener el valor del password
			let password = $("#inputPassword").val();
			let obj = {
				"accion" : "login",
				"usuario" : correo,
				"password" : password,
			};
			// 3. Enviar a validar esos valores
			//Tengo evento pero no selector
			$.post("includes/_funciones.php", obj, function(){
			// 4. En caso de ser valido redireccionar a usuarios.php
			// 5. En caso de no ser valido enviar mensaje de error
			});
		});
	</script>
	</form>
</body>
</html>