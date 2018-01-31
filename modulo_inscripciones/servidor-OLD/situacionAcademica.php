<?php 
	require_once "Config/Autoload.php";
	use Modelos\Alumno;

	Config\Autoload::run();
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');

    if(isset($_GET["legajo"]) && !empty($_GET["legajo"])){
        $legajo = $_GET["legajo"];
        if(Alumno::alumnoExiste($legajo)){
            $alumno = new ALumno($legajo);
            $materias = $alumno->situacionAcademica();
            if(count($materias)==0){
                http_response_code(500);
                echo json_encode(["mensaje"=>"No tiene materias regularizadas"]);
            } else {
                echo json_encode($materias);
            }
            
        } else {
            http_response_code(404);
            echo json_encode(["mensaje"=>"El alumno no existe"]);
        }
        
    }
?>