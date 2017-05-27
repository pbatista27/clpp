<?php
session_start();
if(isset($_POST['nombre']) && !empty($_POST['nombre'])&& isset($_POST['apellido'])&& !empty($_POST['apellido'])&& isset($_POST['cedula'])&& !empty($_POST['cedula'])
&& isset($_POST['cargo'])&& !empty($_POST['cargo'])&& isset($_POST['tipo'])&& !empty($_POST['tipo'])
&& isset($_POST['relacion']) && !empty($_POST['relacion'])&& isset($_POST['codigo'])&& !empty($_POST['codigo'])&& isset($_POST['unidad'])&& !empty($_POST['unidad'])){

$nombre   = ucwords(trim(htmlspecialchars($_POST['nombre'])));
$apellido = ucwords(trim(htmlspecialchars($_POST['apellido'])));
$cedula	  = trim(htmlspecialchars($_POST['cedula']));
$telefono = trim(htmlspecialchars($_POST['telefono']));
$cargo    = ucwords(trim(htmlspecialchars($_POST['cargo'])));
$tipo 	  = trim(htmlspecialchars($_POST['tipo']));
$relacion = trim(htmlspecialchars($_POST['relacion']));
$codigo   = trim(htmlspecialchars($_POST['codigo']));
$unidad   = trim(htmlspecialchars($_POST['unidad']));

if($telefono==Null && ($telefono=="")){
$telefono="00000000000";
}
$a=str_split($cedula);
if($a[0]!="V" && ($a[0]!="E")){
	echo "<h3>Error en la nacionalidad de la cedula</h3>";
	exit();
}

if(!preg_match("/^[Ã±-Ã‘a-zA-Z]+$/",$nombre)){
	 echo "<h3>error nombre solo debe poseer letras</h3>";
	 exit();
	}else if(strlen($nombre)<3){
	echo "<h3>error nombre debe ser mayor a dos caracteres</h3>";
	exit();
	}else if(strlen($nombre)>15){
		echo "<h3>error nombre no puede ser mayor a 15 carateres</h3>";
		exit();
	}else{
	if(!preg_match("/^[Ã±-Ã‘a-zA-Z\s]+$/",$apellido)){
	echo "<h3>error apellido solo debe poseer letras</h3>";
	exit();
	}else if(strlen($apellido)<3){
	echo  "<h3>error apellido debe ser mayor a 2 caracteres</h3>";
	exit();
	}else if(strlen($apellido)>20){
		echo "<h3>error apellido no puede ser mayor a 20 caracteres</h3>";
		exit();
	}else{
	if(!preg_match("/^[E-Ve-v]{1}[\-]{1}[0-9]+$/",$cedula)){
	echo "<h3>error cedula invalida</h3>";
	exit();
	}else if(strlen($cedula)>10 || strlen($cedula)<9){
	echo "<h3>error cedula debe ser mayor a 8 digitos o igual a 10 digito, ejemplo V-19871554</h3>";
	exit();
	}else{
	if(!preg_match("/^[a-zA-Zñ-Ñ\s\,]+$/",$cargo)){
	echo "<h3>error cargo solo debe poseer letras</h3>";
	exit();
	}else{
	if(!preg_match("/^[0-9]+$/",$telefono)){
	echo "<h3>error telefono solo debe poseer numeros</h3>";
	exit();
	}else if(strlen($telefono)!=11){
	echo "<h3>error telefono debe ser igual a 11 caracteres</h3>";
	exit();
}else{
$sql="select idgestion_social from gestion_social where ".$relacion."='$codigo' and tipo_gestion='consejo'";
$sql3="select * from integrantes_gestion where cedula='$cedula'";

require("../php/conexion.php");
$base = new Conexion();
$base->conectar();
$ver = $base->consultar($sql);
if($ver==1){
$datos = $base->extraer($sql);
while($fila = $datos->fetch_array()){
$idgestion_social = $fila['idgestion_social'];
}

$nuevo = $base->consultar($sql3);
if($nuevo==1){
	$sql4="select * from integrantes_gestion where cedula='$cedula' and consejo=1";
	$nuevo1=$base->consultar($sql4);
	if($nuevo1==1){
		echo "<h3>error integrantes ya esta registrado en un consejo comunal</h3>";
		exit();
	}else{
		
	$sql5="select idintegrantes_gestion from integrantes_gestion where cedula='$cedula'";
	$datos2=$base->extraer($sql5);
	while($datos3=$datos2->fetch_array()){
		$idintegrantes_gestion=$datos3['idintegrantes_gestion'];
	}

	$sql6="UPDATE integrantes_gestion SET consejo=1, idconsejo='$idgestion_social' WHERE cedula='$cedula'";
	$base->agregar($sql6);
	$sql7="INSERT INTO cargo_integrantes_gestion(idcargos_integrantes_gestion,cargo,tipo,unidad,idintegrantes_gestion,idgestion_social) VALUES ('','$cargo','$tipo','$unidad','$idintegrantes_gestion','$idgestion_social')";
	$base->agregar2($sql7);
	}

}else{
	$sql8="INSERT INTO integrantes_gestion (idintegrantes_gestion,nombre,apellido,cedula,telefono,consejo,comuna,movimiento,idconsejo,idcomuna) VALUES ('','$nombre','$apellido','$cedula','$telefono',1,0,0,'$idgestion_social',NULL)";
	$base->agregar($sql8);
	$sql10="SELECT idintegrantes_gestion FROM integrantes_gestion WHERE cedula='$cedula'";
	$ver=$base->extraer($sql10);
	while($ver2=$ver->fetch_array()){
		$idintegrantes_gestion=$ver2['idintegrantes_gestion'];
	}
	
	$sql9="INSERT INTO cargo_integrantes_gestion(idcargos_integrantes_gestion,cargo,tipo,unidad,idintegrantes_gestion,idgestion_social) VALUES ('','$cargo','$tipo','$unidad','$idintegrantes_gestion','$idgestion_social')";
	$base->agregar2($sql9);
}
}else{
echo "<h3>error ".$relacion." no existe en el sistema</h3>";
$base->cerrar();
exit();
}

}
}
}
}
}

}else{
echo "<h3>Error todos los datos son obligatorios</h3>";
}

?>
