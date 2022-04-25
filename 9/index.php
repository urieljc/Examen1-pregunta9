<?php
include "conexion.php";
$pdo = new Conexion();

if ($_SERVER["REQUEST_METHOD"]=="GET")
{
	if (isset($_GET["CI"]))
	{
		$sql = $pdo->prepare("select * from PERSONA where CI=:CI");
		$sql->bindValue(':CI',$_GET["CI"]);
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 existen datos");
		echo json_encode($sql->fetchAll());
		exit;
	}
	else
	{
		$sql = $pdo->prepare("select * from PERSONA");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		header("HTTP/1.1 200 existen datos");
		echo json_encode($sql->fetchAll());
		exit;
	}
	header("HTTP/1.1 400 Requerimiento inexistente");
}
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
	$s="insert into PERSONA(CI,NOMBRE,APELLIDO,FECHA_NACIMIENTO,DEPARTAMENTO)";
	$s.=" values (:ci,:nombre,:apellido,:fecha.:depto)";
	$sql = $pdo->prepare($s);
	$sql->bindValue(':ci',$_GET["CI"]);
	$sql->bindValue(':nombre',$_GET["NOMBRE"]);
	$sql->bindValue(':apellido',$_GET["APELLIDO"]);
	$sql->bindValue(':fecha',$_GET["FECHA_NACIMIENTO"]);
    $sql->bindValue(':depto',$_GET["DEPARTAMENTO"]);
	$sql->execute();
	$state=$pdo->lastInsertId();
	if ($state)
	{
		header("HTTP/1.1 200 insercion correcta");
		echo json_encode($state);
		exit;
	}
}
if ($_SERVER["REQUEST_METHOD"]=="DELETE")
{
	$sql = $pdo->prepare("delete from PERSONA where CI=:CI");
	$sql->bindValue(':id',$_GET["CI"]);
	$sql->execute();
	header("HTTP/1.1 200 borrado");
	exit;
}
?>