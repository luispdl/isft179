<?php namespace Modelos;

use Modelos\Carrera;
use Modelos\Materia;

	class Alumno
	{

		//Propiedades
		//public static $tabla = "alumnos";
		
		public $legajo;
		private $con;
		public $nombre;
		public $apellido;
		public $tipo_documento;
		public $numero_documento;

		//Metodos
		public function __construct($legajo){

			$this->con = new Conexion();
			$this->legajo = $legajo;
		 	
		}

		// Metodo estatico que devuelve true si el alumno existe y false si no existe. 
		public static function alumnoExiste($legajo){
			$sql = "SELECT * FROM alumnos WHERE legajo = $legajo";
			$con = new Conexion();
			$resultado = $con->consultaRetorno($sql);
			if(mysqli_num_rows($resultado)==0){
				return false;
			} else {
				return true;
			}
		}

		// Metodo que devuelve todas las materias que el alumno tiene disponible para rendir, según lo que devuelve el Stored Procedure sp_materias_a_rendir
		public function materiasDisponiblesParaRendir(){

			$disponibles = [];

			$sql = "CALL sp_materias_a_rendir($this->legajo)";

			$resultado = $this->con->consultaRetorno($sql);

			while($row = mysqli_fetch_object($resultado)){
				$disponibles[$row->codigo_carrera]["nombre_carrera"] = $row->nombre_carrera;
				$disponibles[$row->codigo_carrera]["codigo_carrera"] = $row->codigo_carrera; 
				$disponibles[$row->codigo_carrera]["materias"][] =$row;
				
			}

			return $disponibles;
		}

		//Metodo que devuelve la fecha de regularización, nota del final, fecha del final de todas las materias regularizadas del alumno.
		public function situacionAcademica(){
			$sql = "SELECT l.codigo_carrera, c.nombre as nombre_carrera, l.codigo_materia, m.nombre as nombre_materia, l.fecha_regular, l.nota_final, l.fecha_final FROM libro_matriz l
			INNER JOIN carreras c on c.codigo_carrera = l.codigo_carrera
			INNER JOIN materias m on m.codigo_materia = l.codigo_materia and m.codigo_carrera = l.codigo_carrera
			WHERE l.legajo = $this->legajo and l.regular = 1";

			$resultado = $this->con->consultaRetorno($sql);
			$materias = [];
			while($row = mysqli_fetch_object($resultado)){

				$materias[$row->codigo_carrera]["nombre_carrera"] = $row->nombre_carrera;
				$materias[$row->codigo_carrera]["codigo_carrera"] = $row->codigo_carrera; 
				$materias[$row->codigo_carrera]["materias"][] =$row;
			}

			return $materias;
		}

		// Guardar las inscripciones a finales de las materias pasadas por parametro.
		public function inscripcionAFinales($materias = []){
			
			// Primero borro las inscripciones ya guardadas en la base de datos
			//Si no se pasan materias por parametros quiere decir que no se inscribio en ninguna materia o cancelo las inscripciones de las materias ya anotadas
			//Entonces solo borro la inscripciones de la base
			$sqlBorrar = "DELETE FROM inscripciones_finales WHERE legajo = $this->legajo";
			$this->con->consultaSimple($sqlBorrar);

			if(count($materias)>0){
				//Genero un solo string con el Insert de todas las materias.
				//A la cabecera INSERT le concateno todos los valores que vienen en materias dentro del foreach
				$sql = "INSERT INTO inscripciones_finales (codigo_carrera, codigo_materia, legajo, fecha_final, modalidad) values";
				
				foreach ($materias as $key => $materia) {
					
					$codigo_carrera = $materia["codigo_carrera"];
					$codigo_materia = $materia["codigo_materia"];
					$legajo = $this->legajo;
					$fecha_final = $materia["fecha_final"];
					$modalidad = $materia["modalidad"];
					$sql =$sql . " ($codigo_carrera, $codigo_materia, $legajo, '$fecha_final', '$modalidad'),";	
				}
				$sql = substr($sql, 0, -1);

				if(!$this->con->consultaRetorno($sql)){
					return false;
				} else {
					return true;
				}
			}
			
		}

		//Metodo que devuelve los datos de las inscripcion del alumno que se encuentran en la base de datos.
		public function estadoInscripcion(){

			$inscripciones = [];
			$sql = "SELECT i.codigo_carrera, c.nombre as nombre_carrera, i.codigo_materia, m.nombre as nombre_materia, i.fecha_final, i.legajo, i.modalidad,
				CONCAT(i.legajo,i.codigo_carrera,i.codigo_materia,date_format(i.fecha_final,'%Y%m%d'),i.nro_operacion) as codigo_operacion 
			FROM inscripciones_finales i 
			INNER JOIN carreras c ON c.codigo_carrera = i.codigo_carrera
			INNER JOIN materias m ON m.codigo_materia = i.codigo_materia AND m.codigo_carrera = i.codigo_carrera
			WHERE legajo=$this->legajo";
			$resultado = $this->con->consultaRetorno($sql);
			while($row = mysqli_fetch_object($resultado)){
				$row->url_codigo_operacion = $this->getUrlCodigoOperacion($row->codigo_operacion);
				$inscripciones[$row->codigo_carrera]["nombre_carrera"] = $row->nombre_carrera;
				$inscripciones[$row->codigo_carrera]["codigo_carrera"] = $row->codigo_carrera; 
				$inscripciones[$row->codigo_carrera]["materias"][] =$row;
			}

			return $inscripciones;
		}

		public function getUrlCodigoOperacion($codigo_operacion){

			$size = 50;

			$urlHost = $this->armar_url();
			$url_codigo_operacion = "$urlHost/barcode/barcode.php?text=$codigo_operacion&size=$size&print=true";
			return $url_codigo_operacion;
		}

		public function armar_url(){
			//Devuelve la url completa de donde son llamados todos los scripts del servidor.

			$enlace_actual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$array_enlace = explode('/',$enlace_actual);
			$array_enlace = array_slice($array_enlace,0,-1);
			$enlace_actual = implode('/',$array_enlace);
			return $enlace_actual;
		} 


		public static function buscarPorLegajo($legajo){
			$con = new Conexion();
			$sql = "SELECT distinct legajo, nombre, apellido, tipo_documento, numero_documento FROM alumnos WHERE legajo=$legajo";
			$resultado = $con->consultaRetorno($sql);
			$row = mysqli_fetch_object($resultado);
			$alumno = new Alumno($row->legajo);
			$alumno->nombre = $row->nombre;
			$alumno->apellido = $row->apellido;
			$alumno->numero_documento = $row->numero_documento;
			$alumno->tipo_documento = $row->tipo_documento;

			return $alumno;
		}

		public static function buscarPorDNI($dni){
			$con = new Conexion();
			$sql = "SELECT legajo, nombre, apellido, tipo_documento, numero_documento FROM alumnos WHERE numero_documento='$dni'";
			$resultado = $con->consultaRetorno($sql);
			$row = mysqli_fetch_object($resultado);
			$alumno = new Alumno($row->legajo);
			$alumno->nombre = $row->nombre;
			$alumno->apellido = $row->apellido;
			$alumno->numero_documento = $row->numero_documento;
			$alumno->tipo_documento = $row->tipo_documento;

			return $alumno;
		}

		public static function buscarPorNombre($nombre){
			$con = new Conexion();
			$sql = "SELECT DISTINCT legajo, nombre, apellido, tipo_documento, numero_documento FROM alumnos WHERE CONCAT(apellido,' ',nombre) LIKE ('%$nombre%')";
			$resultado = $con->consultaRetorno($sql);
			$alumnos = [];
			while($row = mysqli_fetch_object($resultado)){
				$alumno = new Alumno($row->legajo);
				$alumno->nombre = $row->nombre;
				$alumno->apellido = $row->apellido;
				$alumno->numero_documento = $row->numero_documento;
				$alumno->tipo_documento = $row->tipo_documento;
				$alumnos[] =$alumno;
			}
			return $alumnos;
		}
	
	}