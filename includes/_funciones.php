<?php
require_once("con_db.php");
//Recibir variable post
	switch ($_POST["accion"]) {
	//USUARIOS
		case 'login':
			login();
			break;
		case 'consultar_usuarios':
			consultar_usuarios();
			break;
		case 'insertar_usuarios':
			insertar_usuarios();
			break;
		case 'eliminar_usuarios';
			eliminar_usuarios($_POST['id']);
			break;
		case 'editar_usuarios':
			editar_usuarios();
			break;
		case 'consultar_registro_usuarios':
			consultar_registro_usuarios($_POST['id']);
			break;
		case 'carga_foto':
			carga_foto();
			break;
	//TEAM
		case 'consultar_team':
			consultar_team();
			break;
		case 'insertar_integrantes':
			insertar_integrantes();
			break;
		case 'eliminar_integrantes';
			eliminar_integrantes($_POST['id']);
			break;
		case 'consultar_registro_integrantes':
			consultar_registro_integrantes($_POST['id']);
			break;
		case 'editar_integrantes':
			editar_integrantes();
			break;
	//TESTIMONIALS
		case 'consultar_tes':
			consultar_tes();
			break;
		case 'insertar_testimonials':
			insertar_testimonials();
			break;
		case 'eliminar_testimonials';
			eliminar_testimonials($_POST['id']);
			break;
		case 'consultar_registro_testimonials';
			consultar_registro_testimonials($_POST['id']);
			break;
		case 'editar_testimonials':
			editar_testimonials();
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
					session_start();
					error_reporting(0);
					$_SESSION['usuario'] = $email;
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
		$foto = $_POST['foto'];
		$telefono = $_POST['telefono_usr'];
		$pass = $_POST['password_usr'];
		$expresion = '/^[9|9|5][0-10]{8}$/';
		//Validacion de campos vacios
		if (empty($nombre) && empty($correo) && empty($telefono) && empty($pass)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($correo)) {
			echo "3";
		}elseif ($correo != filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			echo "4";
		}elseif (empty($foto)) {
			echo "10";
		}elseif (empty($telefono)) {
			echo "5";
		}elseif (preg_match($expresion, $telefono)) {
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
		$sql = "DELETE FROM usuarios WHERE id_usr = $id";
		$rsl = $mysqli->query($sql);
		if ($rsl) {
			echo "Se elimino correctamente";
		}else{
			echo "Se genero un error, intenta nuevamente";
		}
	}

	function editar_usuarios(){
		global $mysqli;
		extract($_POST);
		$expresion = '/^[9|9|5][0-10]{8}$/';
		//Validacion de campos vacios
		if (empty($nombre_usr) && empty($correo_usr) && empty($telefono_usr) && empty($pass_usr)) {
			echo "0";
		}elseif (empty($nombre_usr)) {
			echo "2";
		}elseif (empty($correo_usr)) {
			echo "3";
		}elseif ($correo_usr != filter_var($correo_usr, FILTER_VALIDATE_EMAIL)) {
			echo "4";
		}elseif (empty($telefono_usr)) {
			echo "5";
		}elseif (preg_match($expresion, $telefono_usr)) {
			echo "6";
		}elseif (empty($password_usr)) {
			echo "7";
		}else{
			$sql = "UPDATE usuarios SET nombre_usr = '$nombre_usr', correo_usr = '$correo_usr', password_usr = '$password_usr', telefono_usr = '$telefono_usr'
			WHERE id_usr = '$id'";
			$rsl = $mysqli->query($sql);
			if ($rsl) {
				echo "8";
			}else{
				echo "9";
			}
		}
	}

	function consultar_registro_usuarios($id){
		global $mysqli;
		$sql = "SELECT * FROM usuarios WHERE id_usr = $id";
		$rsl = $mysqli->query($sql);
		$fila = mysqli_fetch_array($rsl);
		echo json_encode($fila); //Imprime Json encodeado	
	}

	function carga_foto(){
		if (isset($_FILES["foto"])) {
			$file = $_FILES["foto"];
			$nombre = $_FILES["foto"]["name"];
			$temporal = $_FILES["foto"]["tmp_name"];
			$tipo = $_FILES["foto"]["type"];
			$tam = $_FILES["foto"]["size"];
			$dir = "../img/usuarios/";
			$respuesta = [
				"archivo" => "img/usuarios/logotipo.png",
				"status" => 0
			];
			if(move_uploaded_file($temporal, $dir.$nombre)){
				$respuesta["archivo"] = "img/usuarios/".$nombre;
				$respuesta["status"] = 1;
			}
			echo json_encode($respuesta);
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

	function insertar_integrantes(){
		//Conectar a la bd
		global $mysqli;
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$pass = $_POST['password'];
		$puesto = $_POST['puesto'];
		$descripcion = $_POST['descripcion'];
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
		}elseif (empty($fb)) {
			echo "9";
		}elseif (empty($tw)) {
			echo "10";
		}elseif (empty($lk)) {
			echo "11";
		}else{
			$sql = "INSERT INTO team VALUES('', '$nombre', '$correo', '$pass', '$puesto', '$descripcion', '$fb', '$tw', '$lk')";
			$rsl = $mysqli->query($sql);
			echo "1";
		}	
	}
	
	function eliminar_integrantes($id){
		global $mysqli;
		$sql = "DELETE FROM team WHERE id_team = $id";
		$rsl = $mysqli->query($sql);
		if ($rsl) {
			echo "Se elimino correctamente";
		}else{
			echo "Se genero un error, intenta nuevamente";
		}
	}

	function consultar_registro_integrantes($id){
		global $mysqli;
		$sql = "SELECT * FROM team WHERE id_team = $id";
		$rsl = $mysqli->query($sql);
		$fila = mysqli_fetch_array($rsl);
		echo json_encode($fila); //Imprime Json encodeado	
	}

	function editar_integrantes(){
		//Conectar a la bd
		global $mysqli;
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$pass = $_POST['password'];
		$puesto = $_POST['puesto'];
		$descripcion = $_POST['descripcion'];
		$fb = $_POST['fb'];
		$tw = $_POST['tw'];
		$lk = $_POST['lk'];
		$id = $_POST['id'];
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
		}elseif (empty($fb)) {
			echo "9";
		}elseif (empty($tw)) {
			echo "10";
		}elseif (empty($lk)) {
			echo "11";
		}else{
			$sql = "UPDATE team SET nombre = '$nombre', correo = '$correo', password = '$pass', puesto = '$puesto', descripcion = '$descripcion', facebook_link = '$fb', twitter_link = '$tw', linkedin_link = '$lk' WHERE id_team = '$id'";
			$rsl = $mysqli->query($sql);
			if ($rsl) {
				echo "12";
			}else{
				echo "13";
			}
		}	
	}
	//------------------------------FUNCIONES MODULO TESTIMONIALS------------------------------//
	function consultar_tes(){
		//Conectar a la BD
		global $mysqli;
		//Realizar consulta
		$sql = "SELECT * FROM testimonials";
		$rsl = $mysqli->query($sql);
		$array = [];
		while ($row = mysqli_fetch_array($rsl)) {
			array_push($array, $row);
		}
		echo json_encode($array); //Imprime Json encodeado
	}

	function insertar_testimonials(){
		//Conectar a la bd
		global $mysqli;
		$nombre = $_POST['nombre'];
		$puesto = $_POST['puesto'];
		$mensaje = $_POST['mensaje'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($puesto) && empty($mensaje)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($puesto)) {
			echo "3";
		}elseif (empty($mensaje)) {
			echo "4";
		}else{
			$sql = "INSERT INTO testimonials VALUES('', '$nombre', '$puesto', '$mensaje')";
			$rsl = $mysqli->query($sql);
			echo "1";
		}	
	}

	function eliminar_testimonials($id){
		global $mysqli;
		$sql = "DELETE FROM testimonials WHERE id_tes = $id";
		$rsl = $mysqli->query($sql);
		if ($rsl) {
			echo "Se elimino correctamente";
		}else{
			echo "Se genero un error, intenta nuevamente";
		}
	}

	function consultar_registro_testimonials($id){
		global $mysqli;
		$sql = "SELECT * FROM testimonials WHERE id_tes = $id";
		$rsl = $mysqli->query($sql);
		$fila = mysqli_fetch_array($rsl);
		echo json_encode($fila); //Imprime Json encodeado	
	}

	function editar_testimonials(){
		//Conectar a la bd
		global $mysqli;
		$nombre = $_POST['nombre'];
		$puesto = $_POST['puesto'];
		$mensaje = $_POST['mensaje'];
		$id = $_POST['id'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($puesto) && empty($mensaje)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($puesto)) {
			echo "3";
		}elseif (empty($mensaje)) {
			echo "4";
		}else{
			$sql = "UPDATE testimonials SET nombre_tes = '$nombre', puesto_tes = '$puesto', mensaje_tes = '$mensaje' WHERE id_tes = '$id'";
			$rsl = $mysqli->query($sql);
			if ($rsl) {
				echo "5";
			}else{
				echo "6";
			}
		}	
	}
?>