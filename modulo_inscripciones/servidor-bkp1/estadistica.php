<?php



	$con = new Conexion();
	$sql = "SELECT * FROM inscripciones_finales";
	$resultado = $con->query($sql);

	return $resultado;

	//$consulta = mysqli_query($con, "SELECT * FROM inscripciones_finales");
	//return $consulta;
?>