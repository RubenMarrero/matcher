<?php 
  
  namespace matcher\php;

  use \matcher\php\ORM\DatabaseMapper;
  use \matcher\php\ORM\StorageAdapter;
  use \matcher\credentials\credentials;

  require __DIR__."/ORM/DatabaseMapper.php";
  require __DIR__."/ORM/StorageAdapter.php";
  require __DIR__."/../credentials/credentials.php";

  $db_mapper = new DataBaseMapper(new StorageAdapter(credentials::host, credentials::user, credentials::password, credentials::database)); 

  print "\nElige 3 carácteres para la búsqueda: ";
  $mysqli_instance = $db_mapper->adapter->get_db_object();

  $caracteres_busqueda = $mysqli_instance->real_escape_string(trim(fgets(STDIN)));
  if ( 3 < strlen($caracteres_busqueda)) {
    echo "Se han proporcionado más de 3 caracteres. Sólo se usarán los primeros 3.";
  }

  $resultados = $db_mapper->findHotelsAndApartments(array('nombre' => $caracteres_busqueda), 'apartamentos');
  if($resultados){
    foreach( $resultados as $resultado ){
      print "\n".implode(", ", $resultado);
    }
    print "\n\n";

    // Ejemplo para instanciar un objeto modelo con los resultados obtenidos.
    // $ModeloDeLaTabla = $db_mapper->mapToModel($resultado, $tabla);

  } else {
    if( false === $resultado ) { 
     print "\nHubo algun error con la consulta a la base de datos. Comprueba que la tabla y la columna existen."; 
    }
    print "\nNo hubo ningun match\n\n";
  }
