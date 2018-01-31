<?php  
	require_once "Config/Autoload.php";
	use Modelos\Noticia;

	Config\Autoload::run();
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');

	if(isset($_FILES["imagen"])){
		$titulo = $_POST["titulo"];
		$contenido = $_POST["contenido"];
		$imagen = $_FILES["imagen"];
		$tmp_name = $imagen['tmp_name'];
		$nombre = $imagen["name"];
		$tipo = $imagen["type"];
		$carpeta = "./imagenes";
		if($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif') {
			http_response_code(500);
			echo json_encode(["mensaje"=>"El archivo no es una imagen"]); 
		} else {
			$tmp = explode(".",$nombre);
			$extension = end($tmp);
			$src = 'noticia_ISFT179_'.time().'.'.$extension;
			move_uploaded_file($tmp_name, $carpeta .'/' .$src);
			$noticia = new Noticia($titulo, $contenido, $src);
			$resultado = $noticia->guardar();
			if($resultado){
				echo json_encode(["mensaje"=>"La noticia se guardo con exito"]);
			} else {
				http_response_code(500);
				echo json_encode(["mensaje"=>"La noticia no se guardó"]);
			}
		}
	} else {
		http_response_code(400);
		echo json_encode(["mensaje"=>'Imagen invalida']);
	}

?>