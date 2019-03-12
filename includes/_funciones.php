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
	//WORKS
		case 'consultar_works';
			consultar_works();
			break;
		case 'insertar_works';
			insertar_works();
			break;
		case 'editar_works';
			editar_works($_POST['id']);
			break;
		case 'editar_registrow';
			editar_registrow($_POST['id']);
			break;
		case 'eliminar_works';
			eliminar_works($_POST['id']);
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
	//DOWNLOAD
		case 'insertar_download':
			insertar_download();
		break;
		case 'consultar_download':
			consultar_download();
		break;
		case 'consultar_registro_download':
			consultar_registro_download($_POST["registro"]);
		break;
		case 'editar_download':
			editar_download($_POST["registro"]);
		break;
		case 'eliminar_download':
			eliminar_download($_POST["registro"]);
		break;
	//FOOTER
		case 'insertar_footer':
			insertar_footer();
		break;
		case 'consultar_footer':
			consultar_footer();
		break;
		case 'consultar_registro_footer':
			consultar_registro_footer($_POST["registro"]);
		break;
		case 'editar_footer':
			editar_footer($_POST["registro"]);
		break;
		case 'eliminar_footer':
			eliminar_footer($_POST["registro"]);
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
		$img_usr = $_POST['img_usr'];
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
		}elseif (empty($img_usr)) {
			echo "10";
		}elseif (empty($telefono)) {
			echo "5";
		}elseif (preg_match($expresion, $telefono)) {
			echo "6";
		}elseif (empty($pass)) {
			echo "7";
		}else{
			$sql = "INSERT INTO usuarios VALUES('', '$nombre', '$correo', '$img_usr', '$pass', '$telefono', 1)";
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
		}elseif (empty($img_usr)) {
			echo "10";
		}elseif (empty($telefono_usr)) {
			echo "5";
		}elseif (preg_match($expresion, $telefono_usr)) {
			echo "6";
		}elseif (empty($password_usr)) {
			echo "7";
		}else{
			$sql = "UPDATE usuarios SET nombre_usr = '$nombre_usr', correo_usr = '$correo_usr', foto_usr = '$img_usr', password_usr = '$password_usr', telefono_usr = '$telefono_usr'
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
	//------------------------------FUNCIONES MODULO WORKS---------------------------------//
	function consultar_works(){
		global $mysqli;
		$consulta = "SELECT * FROM works";
		$resultado = mysqli_query($mysqli,$consulta);
		$arreglo = [];
		while($fila = mysqli_fetch_array($resultado)){
			array_push($arreglo, $fila);
		}
		echo json_encode($arreglo); //Imprime el JSON ENCODEADO
	}

	function insertar_works(){
		global $mysqli;
		$pname_work = $_POST['pname_work'];
		$description_work = $_POST['description_work'];
		$img_work = $_POST['img_work'];
		if ($pname_work == "") {
			echo "Llena el campo Project Name";
		}elseif ($description_work == "") {
			echo "Llena el campo Description";
		}elseif ($img_work == "") {
			echo "Llena el campo Imagen";
		}else{
		$consulta = "INSERT INTO works VALUES ('','$pname_work','$description_work','$img_work')";
		$resultado = mysqli_query($mysqli,$consulta);
		echo "Se inserto el work en la BD ";
		}
	}
	
	function eliminar_works($id){
		global $mysqli;
		$consulta = "DELETE FROM works WHERE id_work = $id";
		$resultado = mysqli_query($mysqli,$consulta);
		if ($resultado) {
			echo "Se elimino correctamente";
		}else{
			echo "Se genero un error, intenta nuevamente";
		}
		
	}

	function editar_registrow($id){
		global $mysqli;
		$consulta = "SELECT * FROM works WHERE id_work = '$id'";
		$resultado = mysqli_query($mysqli,$consulta);
		
		$fila = mysqli_fetch_array($resultado);
		echo json_encode($fila);
	}
	
	function editar_works($id){
		global $mysqli;
		$pname_work = $_POST['pname_work'];
		$description_work = $_POST['description_work'];
		$img_work = $_POST['img_work'];
		if ($pname_work == "") {
			echo "Llene el campo Project name";
		}elseif ($description_work == "") {
			echo "Llene el campo Description";
		}elseif ($img_work == "") {
			echo "Llene el campo Img";
		}else{
		echo "Se edito el work correctamente";
		$consulta = "UPDATE works SET pname_work = '$pname_work', description_work = '$description_work', img_work = '$img_work' WHERE id_work = '$id'";
		$resultado = mysqli_query($mysqli,$consulta);
		
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
		$img_team = $_POST['img_team'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($correo) && empty($pass) && empty($puesto) && empty($descripcion) && empty($img_team) && empty($fb) && empty($tw) && empty($lk)) {
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
		}elseif (empty($img_team)) {
			echo "8";
		}else{
			$sql = "INSERT INTO team VALUES('', '$nombre', '$correo', '$pass', '$puesto', '$descripcion', '$fb', '$tw', '$lk', '$img_team')";
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
		$img_team = $_POST['img_team'];
		$id = $_POST['id'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($correo) && empty($pass) && empty($puesto) && empty($descripcion) && empty($img_team) && empty($fb) && empty($tw) && empty($lk)) {
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
		}elseif (empty($img_team)) {
			echo "8";
		}else{
			$sql = "UPDATE team SET nombre = '$nombre', correo = '$correo', password = '$pass', puesto = '$puesto', descripcion = '$descripcion', facebook_link = '$fb', twitter_link = '$tw', linkedin_link = '$lk', img_team = '$img_team' WHERE id_team = '$id'";
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
		$foto_tes = $_POST['foto_tes'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($puesto) && empty($mensaje) && empty($foto_tes)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($puesto)) {
			echo "3";
		}elseif (empty($mensaje)) {
			echo "4";
		}elseif (empty($foto_tes)) {
			echo "7";
		}else{
			$sql = "INSERT INTO testimonials VALUES('', '$nombre', '$puesto', '$mensaje', '$foto_tes')";
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
		$foto_tes = $_POST['foto_tes'];
		$id = $_POST['id'];
		//Validacion de campos vacios
		if (empty($nombre) && empty($puesto) && empty($mensaje) && empty($foto_tes)) {
			echo "0";
		}elseif (empty($nombre)) {
			echo "2";
		}elseif (empty($puesto)) {
			echo "3";
		}elseif (empty($mensaje)) {
			echo "4";
		}elseif (empty($foto_tes)) {
			echo "7";
		}else{
			$sql = "UPDATE testimonials SET nombre_tes = '$nombre', puesto_tes = '$puesto', mensaje_tes = '$mensaje', foto_tes = '$foto_tes' WHERE id_tes = '$id'";
			$rsl = $mysqli->query($sql);
			if ($rsl) {
				echo "5";
			}else{
				echo "6";
			}
		}	
	}
	//------------------------------FUNCIONES MODULO DOWNLOAD------------------------------//
	function insertar_download(){
		global $mysqli;
		$titulo_download = $_POST['titulo_download'];
		$subtitulo_download = $_POST['subtitulo_download'];
		$consulta = "INSERT INTO download VALUES('', '$titulo_download', '$subtitulo_download')";
		$resultado = mysqli_query($mysqli, $consulta);
		if ($resultado) {
				echo "Se agrego nuevo registro";
			}else{
				echo "Hubo un problema";
			}
		}
		function consultar_download(){
		global $mysqli;
		$consulta = "SELECT * FROM download";
		$resultado = mysqli_query($mysqli, $consulta);
		$arreglo = [];
		while($fila = mysqli_fetch_array($resultado)){
			array_push($arreglo, $fila);
		}
		echo json_encode($arreglo); //Imprime el JSON ENCODEADO
		}
		function consultar_registro_download($id){
		global $mysqli;
		$sql = "SELECT * FROM download WHERE id_download = $id";
		$rsl = $mysqli->query($sql);
		$fila = mysqli_fetch_array($rsl);
		echo json_encode($fila); //Imprime Json encodeado
		}
		function editar_download($id){
		global $mysqli;
		$titulo_download = $_POST['titulo_download'];
		$subtitulo_download = $_POST['subtitulo_download'];
		$consulta = "UPDATE download SET titulo_download = '$titulo_download', subtitulo_download = '$subtitulo_download' WHERE id_download = '$id'";
		$resultado = mysqli_query($mysqli, $consulta);
		if($resultado){
				echo "Se editó correctamente";
		}else{
				echo "No se pudo editar karnal";
		}
		}
		function eliminar_download($id){
		global $mysqli;
		$consulta = "DELETE FROM download WHERE id_download = $id";
		$resultado = mysqli_query($mysqli, $consulta);
		if ($resultado) {
			echo "ya fue el dato karnal";
		}else{
			echo "No se quiere ir el dato karnal";
		}
		}
	//------------------------------FUNCIONES MODULO FOOTER------------------------------//
	function insertar_footer(){
		global $mysqli;
		$titulo_direccion = $_POST['titulo_direccion'];
		$direccion = $_POST['direccion'];
		$titulo_compartir = $_POST['titulo_compartir'];
		$link_fb = $_POST['link_fb'];
		$link_ld = $_POST['link_ld'];
		$link_tw = $_POST['link_tw'];
		$titulo_about = $_POST['titulo_about'];
		$about = $_POST['about'];
		$copyright = $_POST['copyright'];
		
		$consulta = "INSERT INTO footer VALUES('', '$titulo_direccion', '$direccion', '$titulo_compartir', '$link_fb', '$link_ld', '$link_tw', '$titulo_about', '$about', '$copyright')";
		$resultado = mysqli_query($mysqli, $consulta);
		
		if ($resultado) {
			echo "Se agrego nuevo registro";
		}else{
			echo "Hubo un problema";
			}
		}
		function consultar_footer(){
		global $mysqli;
		$consulta = "SELECT * FROM footer";
		$resultado = mysqli_query($mysqli, $consulta);
		$arreglo = [];
		while($fila = mysqli_fetch_array($resultado)){
			array_push($arreglo, $fila);
		}
		echo json_encode($arreglo); //Imprime el JSON ENCODEADO
		}
		function consultar_registro_footer($id){
		global $mysqli;
		$sql = "SELECT * FROM footer WHERE id_footer = $id";
		$rsl = $mysqli->query($sql);
		$fila = mysqli_fetch_array($rsl);
		echo json_encode($fila); //Imprime Json encodeado	
		}
		function editar_footer($id){
		global $mysqli;
		$titulo_direccion = $_POST['titulo_direccion'];
		$direccion = $_POST['direccion'];
		$titulo_compartir = $_POST['titulo_compartir'];
		$link_fb = $_POST['link_fb'];
		$link_ld = $_POST['link_ld'];
		$link_tw = $_POST['link_tw'];
		$titulo_about = $_POST['titulo_about'];
		$about = $_POST['about'];
		$copyright = $_POST['copyright'];
		$consulta = "UPDATE footer SET titulo_direccion = '$titulo_direccion', direccion = '$direccion', titulo_compartir = '$titulo_compartir', link_fb = '$link_fb', link_ld ='$link_ld', link_tw ='$link_tw', titulo_about = '$titulo_about', about = '$about', copyright = '$copyright' WHERE id_footer = '$id'";
		$resultado = mysqli_query($mysqli, $consulta);
		if($resultado){
			echo "Se editó correctamente";
		}else{
			echo "No se pudo editar karnal";
		}
		}
		function eliminar_footer($id){
		global $mysqli;
		$consulta = "DELETE FROM footer WHERE id_footer = $id";
		$resultado = mysqli_query($mysqli, $consulta);
		if ($resultado) {
			echo "ya fue el dato karnal";
		}else{
			echo "No se quiere ir el dato karnal";
		}
		}
?>