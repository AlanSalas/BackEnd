<?php 
	require_once("con_db.php");
//Recibir variable post
	switch ($_POST["accion"]) {
		case 'login':
			login();
			break;
		
		default:
			# code...
			break;
	}
	function login(){
		//echo "Tu usuario es: ".$_POST["usuario"]. ", Tu contraseña es: ".$_POST["password"];
		//Conectar a la BD
		//Si el usuario y pass están vacios imprimir 3
		//Consultar a la bd que el usuario exista
			// Si el usuario existe, consultar que el password sea correcto
				//Si el password no es correcto, imprimir 0
				// Si el usuario es correcto, imprimir 1
			// Si el usuario no existe, imprimir 2
	}
?>