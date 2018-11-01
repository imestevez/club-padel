<?php

class MESSAGE{

	var $mensaje; // Almacena el mensaje enviado por el controlador
	var $msqli; //Almacena los datos de la coexión a la BD
	var $origen; //Almacena el origen de la orden
	var $resultado; // array para almacenar los datos del usuario


	function __construct($datos, $origen){
		if(is_string($datos)){ //Si en datos se envía unicamente un string
			$this->mensaje = $datos;
			$this->origen = $origen;
			$this->render();
		}else { //si es una lista con mas elementos
			$this->mensaje = $datos['mensaje'];
			$this->origen = $origen;
			$this->render(); //Se muestra el string
		}
	}

//funcion que muestra solo el mensaje

function render(){
      include 'HEADER_View.php';
?>
     

    <section id="banner">
            <h2>Mensaje del sistema</h2>
            <p><?php echo $this->mensaje ?></p>
    </section>
    

<?php
  include 'FOOTER_View.php';
} // fin mensaje()

}//fin clase
?>