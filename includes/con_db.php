<?php
$server = "challengercorp.com.mx";
$db = "challeng_segundo_parcial";
$user = "challeng_word" ;
$password = "Estrella.100";
$mysqli = new mysqli($server, $user, $password, $db);
   if($mysqli->connect_errno){
	   echo "Lo sentimos este sitio web está experimentando problemas";
	   echo "Error: Fallo al conectarse a MySQL debido a: \n";
	   echo "Errno: " . $mysqli->connect_errno . "\n";
	   echo "Errno: " . $mysqli->connect_errno . "\n";
	   exit;
   }
?>