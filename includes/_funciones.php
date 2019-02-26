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
		case 'eliminar_usuario';
			eliminar_usuarios($_POST['id']);
			break;
		case 'editar_usuario':
			editar_usuarios($_POST['id']);
			break;
		case 'consultar_team':
			consultar_team();
			break;
		case 'insertar_integrante':
			insertar_integrante();
			break;
		default:
			# code...
			break;
	}
	//------------------------------FUNCIONES MODULO USUARIOS------------------------------//
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

	function eliminar_usuarios($id){
		global $mysqli;
		$consulta = "DELETE FROM usuarios WHERE id_usr = $id";
		$resultado = mysqli_query($mysqli,$consulta);
		if ($resultado) {
			echo "Se elimino correctamente";
		}else{
			echo "Se genero un error, intenta nuevamente";
		}
	}
	
	function editar_usuarios($id){
		global $mysqli;
		$nombre = $_POST['nombre_usr'];
		$correo = $_POST['correo_usr'];
		$telefono = $_POST['telefono_usr'];
		$pass = $_POST['password_usr'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($correo) && empty($telefono) && empty($pass)) {
			//echo "0";
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
			$sql = "UPDATE usuarios SET nombre_usr = '$nombre', correo_usr = '$correo', telefono_usr = '$telefono', password_usr = '$pass' WHERE id_usr = $id";
			$rsl = $mysqli->query($sql);
			if ($rsl) {
				echo "Se edito el usuario correctamente";
			}else{
				echo "Se genero un error, intenta nuevamente";
			}
		}
	}
	//------------------------------FUNCIONES MODULO OUR TEAM------------------------------//
	function consultar_team(){
		//Conectar a la BD
		global $mysqli;
		//Realizar consulta
		$sql = "SELECT * FROM team";
		$rsl = $mysqli->query($sql);
		$array = [];
		while ($row = mysqli_fetch_array($rsl)) {
			array_push($array, $row);
		}
		echo json_encode($array); //Imprime Json encodeado	
	}

	function insertar_integrante(){
		//Conectar a la bd
		global $mysqli;
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$pass = $_POST['password'];
		$puesto = $_POST['puesto'];
		$descripcion = $_POST['descripcion'];
		$foto = $_POST['foto'];
		$fb = $_POST['fb'];
		$tw = $_POST['tw'];
		$lk = $_POST['lk'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($correo) && empty($pass) && empty($puesto) && empty($descripcion) && empty($foto) && empty($fb) && empty($tw) && empty($lk)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($correo)) {
			echo "3";
		}elseif ($correo != filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			echo "4";
		}elseif (empty($pass)) {
			echo "5";
		}elseif (empty($puesto)) {
			echo "6";
		}elseif (empty($descripcion)) {
			echo "7";
		}elseif (empty($foto)) {
			echo "8";
		}elseif (empty($fb)) {
			echo "9";
		}elseif (empty($tw)) {
			echo "10";
		}elseif (empty($lk)) {
			echo "11";
		}else{
			$sql = "INSERT INTO team VALUES('', '$nombre', '$correo', '$pass', '$puesto', '$descripcion', '$foto', '$fb', '$tw', '$lk')";
			$rsl = $mysqli->query($sql);
			echo "1";
		}	
	}	
?>