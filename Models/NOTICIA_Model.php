<?php
class NOTICIA_Model{
	var $id;
	var $titulo;
	var $descripcion;
	var $link;
	var $mysqli;

	function __construct($id, $titulo, $descripcion, $link){
		$this->id = $id;
		$this->titulo = $titulo;
		$this->descripcion = $descripcion;
		$this->link = $link;

		include_once '../Functions/Access_DB.php';
		$this->mysqli = ConnectDB();
	}

	function SHOWALL(){
		$sql = "SELECT * FROM NOTICIA ORDER BY  ID DESC";
		if (!($resultado = $this->mysqli->query($sql))){
			$this->mensaje['mensaje'] =  'ERROR: Fallo en la consulta sobre la base de datos';
			return $this->mensaje;
		}
		else{
			return $resultado;
		}
	}

	function ADD(){
		if (($this->titulo <> '') || ($this->descripcion <> '')){
				$sql = "INSERT INTO NOTICIA (ID,TITULO,DESCRIPCION,LINK) VALUES (NULL,'$this->titulo','$this->descripcion','$this->link')";
				if(!$resultado = $this->mysqli->query($sql) ){
					return 'ERROR: Fallo en la consulta sobre la base de datos';
				}else{
					return 'Noticia creada correctamente';
				}
		}else{
			$this->mensaje['mensaje'] = 'ERROR: Introduzca todos los valores de todos los campos';
			return $this->mensaje;
		}
	}

	function DELETE(){
		$sql = "DELETE FROM NOTICIA WHERE (ID = $this->id)";
		if(!$resultado = $this->mysqli->query($sql) ){
			return 'ERROR: Fallo en la consulta sobre la base de datos';
		}else{
			return 'Noticia borrada correctamente';
		}
	}

}
?>
