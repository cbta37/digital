<?php
  if($peticionAjax){
    require_once "../config/server.php";
  }else{
    require_once "./config/server.php";
  }

  class mainModel{
    //Función para conectar a la bd
    protected static function connectionBD(){
      $connection = new PDO( SGBD, USER, PASSWORD );
      $connection->exec("SET CHARACTER SET utf8");

      return $connection;
    }

    //Función para ejecutar consultas simples
    protected static function ejecutarConsultaSimple($consulta){
      $sql = self::connectionBD()->prepare($consulta);
      $sql->execute();
      return $sql;
    }

    //encriptar cadenas
    public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

    //desencriptar cadenas
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

    //función para generar códigos aleatorios
    protected static function generarCodigoAleatorio($letra, $longitud, $numero){
      for( $i=1; i<=$longitud; $i++ ){
        $aleatorio = rand(0,9);
        $letra.=$aleatorio;
      }
      return $letra."-".$numero;
    }

    //función para limpiar cadenas
    protected static function limpiarCadena($cadena){
      $cadena =trim($cadena);
      $cadena = stripslashes($cadena);
      $cadena = str_ireplace("<script>", "", $cadena);
      $cadena = str_ireplace("</script>", "", $cadena);    
      $cadena = str_ireplace("<script src>", "", $cadena);
      $cadena = str_ireplace("<script type=>", "", $cadena);
      $cadena = str_ireplace("SELECT * FROM", "", $cadena);
      $cadena = str_ireplace("DELETE FROM", "", $cadena);
      $cadena = str_ireplace("INSERT INTO", "", $cadena);
      $cadena = str_ireplace("DROP TABLE", "", $cadena);
      $cadena = str_ireplace("DROP DATABASE", "", $cadena);
      $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
      $cadena = str_ireplace("SHOW TABLES", "", $cadena);
      $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
      $cadena = str_ireplace("<?php", "", $cadena);
      $cadena = str_ireplace("?>", "", $cadena);
      $cadena = str_ireplace("--", "", $cadena);
      $cadena = str_ireplace(">", "", $cadena);
      $cadena = str_ireplace("<", "", $cadena);
      $cadena = str_ireplace("[", "", $cadena);
      $cadena = str_ireplace("]", "", $cadena);
      $cadena = str_ireplace("^", "", $cadena);
      $cadena = str_ireplace("==", "", $cadena);
      $cadena = str_ireplace(";", "", $cadena);
      $cadena = str_ireplace("::", "", $cadena);
      $cadena = stripslashes($cadena);
      $cadena =trim($cadena);
      
      return $cadena;
    }

    //función para verificar el formato de los datos
    protected static function verificarDatos($filter, $string){
      if(preg_match("/^".$filter."$/", $string)){
        return false;
      }else{
        return true;
      }
    }

    //validar fechas
    protected static function verificarFecha($fecha){
      $valores = explode("-", $fecha);
      if(count($valores)==3 && checkdate($valores[1], $valores[2], $valores[0])){
        return false;
      }else{
        return true;
      }
    }

    /* 
    * Función personalizada para comprimir y 
    * subir una imagen mediante PHP
    */ 
    function compressImage($source, $destination, $quality) { 
      // Obtenemos la información de la imagen
      $imgInfo = getimagesize($source); 
      $mime = $imgInfo['mime']; 
      
      // Creamos una imagen
      switch($mime){ 
          case 'image/jpeg': 
              $image = imagecreatefromjpeg($source); 
              break; 
          case 'image/png': 
              $image = imagecreatefrompng($source); 
              break; 
          case 'image/gif': 
              $image = imagecreatefromgif($source); 
              break; 
          default: 
              $image = imagecreatefromjpeg($source); 
      } 
      
      // Guardamos la imagen
      imagejpeg($image, $destination, $quality); 
      
      // Devolvemos la imagen comprimida
      return $destination; 
    } 

    //función paginador de tablas
    protected static function paginadorTablas($pagina, $npaginas, $url, $botones){
      $tabla = '<nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">';
      
      if($pagina == 1){   
        $tabla.='<li class="page-item disabled"><a class="page-link">
        <i class="fas fa-angle-double-left"></i></a></li>';
      }else{
        $tabla.='
          <li class="page-item"><a class="page-link" href="'.$url.'1/">
            <i class="fas fa-angle-double-left"></i></a></li>
          <li class="page-item"><a class="page-link" href="'.$url.($pagina-1).'/">
            Anterior</a></li>';
      }

      $ci = 0;
      for( $i=$pagina; $i<=$npaginas; $i++ ){
        if( $ci >= $botones ) break;
        if($pagina == $i){
          $tabla.='
          <li class="page-item"><a class="page-link active" href="'.$url.$i.'/">
            '.$i.'</a></li>';
        }else{
          $tabla.='
          <li class="page-item"><a class="page-link" href="'.$url.$i.'/">
            '.$i.'</a></li>';
        }
        $ci++;
      }

      if($pagina == $npaginas){   
        $tabla.='<li class="page-item disabled"><a class="page-link">
        <i class="fas fa-angle-double-right"></i></a></li>';
      }else{
        $tabla.='
          <li class="page-item"><a class="page-link" href="'.$url.($pagina+1).'/">
              Siguiente</a></li>
          <li class="page-item"><a class="page-link" href="'.$url.$npaginas.'/">
              <i class="fas fa-angle-double-right"></i></a></li>';
      }

      $tabla.='</ul></nav>';

      return $tabla;
    }
  }