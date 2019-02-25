<?php
require_once("con_db.php");
//Recibir variable post
	switch ($_POST["accion"]) {
		case 'login':
			login();
			break;
		case 'consultar_usuarios':
			consultar_usuarios();
			break;
		case 'insertar_usuarios':
			insertar_usuarios();
			break;
		
		default:
			# code...
			break;
	}
	//------------------------------FUNCIONES------------------------------//
	function insertar_usuarios(){
		//Conectar a la bd
		global $mysqli;
		$nombre = $_POST['nombre_usr'];
		$correo = $_POST['correo_usr'];
		$telefono = $_POST['telefono_usr'];
		$pass = $_POST['password_usr'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($correo) && empty($telefono) && empty($pass)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($correo)) {
			echo "3";
		}elseif ($correo != filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			echo "4";
		}elseif (empty($telefono)) {
			echo "5";
		}elseif ($telefono != filter_var($telefono, FILTER_VALIDATE_INT)) {
			echo "6";
		}elseif (empty($pass)) {
			echo "7";
		}else{
			$sql = "INSERT INTO usuarios VALUES('', '$nombre', '$correo', '$pass', '$telefono', 1)";
			$rsl = $mysqli->query($sql);
			echo "1";
		}
	}
	function consultar_usuarios(){
		//Conectar a la BD
		global $mysqli;
		//Realizar consulta
		$sql = "SELECT * FROM usuarios";
		$rsl = $mysqli->query($sql);
		$array = [];
		while ($row = mysqli_fetch_array($rsl)) {
			array_push($array, $row);
		}
		echo json_encode($array); //Imprime Json encodeado		
	}

	function login(){
		//echo "Tu usuario es: ".$_POST["usuario"]. ", Tu contraseña es: ".$_POST["password"];
		//Conectar a la BD
		global $mysqli;
		$email = $_POST["usuario"];
		$pass = $_POST["password"];
		//Si el usuario y pass están vacios imprimir 3
		if (empty($email) && empty($pass)) {
			echo "3";
		//Si no están vacios consultar a la bd que el usuario exista.
		}else {
			$sql = "SELECT * FROM usuarios WHERE correo_usr = '$email'";
			$rsl = $mysqli->query($sql);
			$row = $rsl->fetch_assoc();
			//Si el usuario no existe, imprimir 2
			if ($row == 0) {
				echo "2";
			//Si hay resultados verificar datos
			}else{
				$sql = "SELECT * FROM usuarios WHERE correo_usr = '$email' AND password_usr = '$pass'";
				$rsl = $mysqli->query($sql);
				$row = $rsl->fetch_assoc();
				//Si el password no es correcto, imprimir 0
				if ($row["password_usr"] != $pass) {
					echo "0";
				//Si el usuario es correcto, imprimir 1
				}elseif ($email == $row["correo_usr"] && $pass == $row["password_usr"]) {
					echo "1";
				}
			}
		} 	
	}
?>