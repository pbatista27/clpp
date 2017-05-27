<?php
session_start();
if($_SESSION['tipo']=="administrador" ||($_SESSION['tipo']=="operador")){
$base = null;
if(isset($_POST['campo'])&& !empty($_POST['campo']) && isset($_POST['nuevovalor'])&& !empty($_POST['nuevovalor'])&& isset($_POST['id'])&& !empty($_POST['id'])&&
isset($_POST['tipo'])&& !empty($_POST['tipo']) && isset($_POST['idmovimiento'])){

$campo = trim(htmlspecialchars($_POST['campo']));
$valor = trim(htmlspecialchars($_POST['nuevovalor']));
$id = intval(trim(htmlspecialchars($_POST['id'])));
$tipo = trim(htmlspecialchars($_POST['tipo']));
$idmovimiento=intval(trim(htmlspecialchars($_POST['idmovimiento'])));


require("../php/conexion.php");
$base = new Conexion();
switch($tipo){

case "movimientos":

if($campo=="nombre_gestion"){
$base = new Conexion();
$base->conectar();
$sql = "update gestion_social set ".$campo."='".$valor."' where idgestion_social='".$id."' and tipo_gestion='movimiento' limit 1";
$base->actualizar($sql);
$base->cerrar();

}else if($campo=="parroquia"){

    if(!preg_match("/^[a-zA-Z\s]+$/",$valor)){
    echo "<h3>Error en parroquia</h3>";
    exit();
    }

$tgh= array("MARHUANTA","Marhuanta","marhuanta","Zea","zea","ZEA","sabanita","Sabanita","SABANITA",
"Catedral","catedral","CATEDRAL","orinoco","Orinoco","ORINOCO","Panapana","panapana","PANAPANA",
"Agua Salada","agua salada","AGUA SALADA","Agua salada","agua Salada","Vista Hermosa","vista Hermosa",
"Vista hermosa","VISTA HERMOSA","vista hermosa","jose antonio paez","Jose Antonio Paez","jose Antonio Paez","jose antonio Paez","Jose antonio paez","Jose Antonio paez");
$conntadd = 0;
for($i=0;$i<count($tgh);$i++){
    if($valor!=$tgh[$i]){
    $conntadd=$conntadd+1;
    }
    }
    if($conntadd==count($tgh)){
    echo "<h3>Error en parroquia, parroquia no existe</h3>";
    exit();
    }


$base = new Conexion();
$base->conectar();
$sql = "update gestion_social set ".$campo."='".$valor."' where idgestion_social='".$id."' and tipo_gestion='movimiento' limit 1";
$base->actualizar($sql);
$base->cerrar();
}else if($campo=='tipo'){
    if(!preg_match("/^[a-zA-Z\s]+$/",$valor)){
        echo "<h3>Error en tipo</h3>";
        exit();
    }
$base = new Conexion();
$base->conectar();
$sqlverr="update gestion_social set ".$campo."='".$valor."' where idgestion_social='".$id."' and tipo_gestion='movimiento' limit 1";
$base->actualizar($sqlverr);
$base->cerrar();
}else{
    if($campo=="rif"){
    if(!preg_match("/^[J]{1}[\-]{1}[0-9]{8}[\-]{1}[0-9]{1}+$/",$valor)){
    echo "<h3>Error en rif</h3>";
    exit();
    }
     $sql="select rif from gestion_social where rif='$valor' and tipo_gestion='movimiento' and not idgestion_social='$id'";
         $base = new Conexion();
         $base->conectar();
         $consulta= $base->consultar($sql);
         if($consulta==1){
            echo "<h3>Error rif ya estas registrado en un movimiento social</h3>";
            $base->cerrar();
            exit();
         }
    }else if($campo=="fecha_inicio"){
        if(!preg_match("/^[0-9]{4}[\-]{1}[0-9]{2}[\-]{1}[0-9]{2}+$/",$valor)){
        echo "<h3>Error en fecha de inicio</h3>";
        exit();
        }else{
        $nuevafecha = Date("Y-m-d");
        if($valor > $nuevafecha){
        echo "<h3>Error fecha no puede ser mayor a actual</h3>";
        exit();
        }
        }
    }else if($campo=="fecha_registro"){
        if(!preg_match("/^[0-9]{4}[\-]{1}[0-9]{2}[\-]{1}[0-9]{2}+$/",$valor)){
        echo "<h3>Error en fecha de registro</h3>";
        exit();
        }else{
        $nuevafecha = Date("Y-m-d");
        if($valor > $nuevafecha){
        echo "<h3>Error fecha no puede ser mayor a actual</h3>";
        exit();
        }
        }
    }else if($campo=="fecha_vencimiento"){
    if(!preg_match("/^[0-9]{4}[\-]{1}[0-9]{2}[\-]{1}[0-9]{2}+$/",$valor)){
        echo "<h3>Error en fecha de vencimiento</h3>";
        exit();

    }
    }else if($campo=="clave_gestion"){
        $valor = hash('ripemd160',$valor);
    }


$sql = "update gestion_social set ".$campo."='".$valor."' where idgestion_social='".$id."' and tipo_gestion='movimiento' limit 1";
$base = new Conexion();
$base->conectar();
$base->actualizar($sql);
$base->cerrar();
}
break;
case "documentos":

if($campo=="acta"){
    if(!preg_match("/^[a-zA-Z]{2}+$/",$valor)){
    echo "<h3>Error en acta</h3>";
    exit();
    }
if($valor!="SI" && ($valor!="si" && ($valor!="Si" &&($valor!="no"&&($valor!="NO"&&($valor!="No")))))){
 echo "<h3>Error en acta</h3>";
 exit();
 }
}else if($campo=="nomina"){
    if(!preg_match("/^[a-zA-Z]{2}+$/",$valor)){
    echo "<h3>Error en nomina</h3>";
    exit();
    }
if($valor!="SI" && ($valor!="si" && ($valor!="Si" &&($valor!="no"&&($valor!="NO"&&($valor!="No")))))){
 echo "<h3>Error en nomina</h3>";
 exit();
 }
}else if($campo=="constancia"){
    if(!preg_match("/^[a-zA-Z]{2}+$/",$valor)){
    echo "<h3>Error en constancia eleccion</h3>";
    exit();
    }
if($valor!="SI" && ($valor!="si" && ($valor!="Si" &&($valor!="no"&&($valor!="NO"&&($valor!="No")))))){
 echo "<h3>Error en constancia eleccion</h3>";
 exit();
 }
}else if($campo=="cedulas"){
    if(!preg_match("/^[a-zA-Z]{2}+$/",$valor)){
    echo "<h3>Error en cedulas</h3>";
    exit();
    }
if($valor!="SI" && ($valor!="si" && ($valor!="Si" &&($valor!="no"&&($valor!="NO"&&($valor!="No")))))){
 echo "<h3>Error en cedulas</h3>";
 exit();
 }
}

$sql ="update gestion_social set ".$campo."='".$valor."' where idgestion_social='".$id."' and tipo_gestion='movimiento' limit 1";
$base = new Conexion();
$base->conectar();
$base->actualizar($sql);
$base->cerrar();
break;

case "integrantes":
if($campo=="nombre"){
    if(!preg_match("/^[a-zA-zñ-Ñ]+$/",$valor)){
        echo "<h3>Error en nombre</h3>";
        exit();
    }
    if(strlen($valor)>15){
    echo "<h3>Error nombre no debe ser mayor a 15 caracteres</h3>";
    exit();
    }
$base = new Conexion();
$base->conectar();

$sql="update integrantes_gestion set ".$campo."='".$valor."' where idintegrantes_gestion='".$id."' and movimiento=1 limit 1";
$base->actualizar($sql);
$base->cerrar();
}else if($campo=="apellido"){
    if(!preg_match("/^[a-zA-ZÑ-ñ\s]+$/",$valor)){
        echo "<h3>Error en apellido</h3>";
        exit();
    }
    if(strlen($valor)>20){
    echo "<h3>Error apellido no debe ser mayor a 20 caracteres</h3>";
    exit();
    }
$base = new Conexion();
$base->conectar();
$sql="update integrantes_gestion set ".$campo."='".$valor."' where idintegrantes_gestion='".$id."' and movimiento=1 limit 1";
$base->actualizar($sql);
$base->cerrar();
}else if($campo=="cedula"){
    $a=str_split($valor);
    if($a[0]!="v" and ($a[0]!="V" and ($a[0]!="E" and ($a[0]!="e")))){
        echo "<h3>Error en la nacionalida de la cedula</h3>";
      exit();
     }
    if(!preg_match("/^[E-V]{1}[\-]{1}[0-9]+$/",$valor)){
    echo "<h3>Error en cedula</h3>";
    exit();
    }
    if(strlen($valor)>10 || (strlen($valor)<9)){
    echo "<h3>Error en cedula</h3>";
    exit();
    }
     $sql="select cedula from integrantes_gestion where cedula='$valor' and not idintegrantes_gestion='$id'";
    $base = new Conexion();
    $base->conectar();
    $consult=$base->consultar($sql);
    if($consult==1){
        echo "<h3>Error cedula ya exite en el sistema</h3>";
        $base->cerrar();
        exit();

    }
$sql="update integrantes_gestion set ".$campo."='".$valor."' where idintegrantes_gestion='".$id."' and movimiento=1 limit 1";
$base->actualizar($sql);
$base->cerrar();
}else{

if($campo=="telefono"){
    if(!preg_match("/^[0-9]{11}+$/",$valor)){
    echo "<h3>Error en telefono</h3>";
    exit();
    }
    if($valor=="00000000000"){

    }else{
    $codigo = substr($valor,0,4);

	if($codigo!="0412" &&($codigo!="0416" &&($codigo!="0426" &&($codigo!="0414"
	&&($codigo!="0424" &&($codigo!="0285"))))))
	{
	echo "<h3>Error en codigo del campo {$campo} no es valido</h3>";
	exit();
	}
}
    $base = new Conexion();
    $base->conectar();
    $sql="update integrantes_gestion set ".$campo."='".$valor."' where idintegrantes_gestion='".$id."' and movimiento=1 limit 1";
    $base->actualizar($sql);
    $base->cerrar();

}else if($campo=="cargo"){

    if(!preg_match("/^[a-zA-Zñ-Ñ\s]+$/",$valor)){
    echo "<h3>Error en cargo</h3>";
    exit();
    }
    $sql="update cargo_integrantes_gestion set ".$campo."='".$valor."' where idintegrantes_gestion='".$id."' and idgestion_social='$idmovimiento' limit 1";
    $base = new Conexion();
    $base->conectar();
    $base->actualizar($sql);
    $base->cerrar();

}


}
break;
default:
echo "<h3>error</h3>";
break;
}

}else{
echo "<h3>Error al actualizar datos</h3>";
}
}else{
?>
<script>
window.location="../index.php";
</script>
<?php
}
?>
