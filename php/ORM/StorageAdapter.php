<?php 

/**
 *  Esta es la unica clase que interactua directamente con la base de datos.
 */
class StorageAdapter
{

  private $db_object_abstraction;

  // Idealmente este número no debería de ser nunca superior a 1
  // en caso de que esto llegase a suceder debería de entenderse por qué
  // y saber explicar por qué es necesario que esa sea la mejor opción.
  // Para una estructura tan simple como esta nunca debería de ser más
  // de 1 y si llegase a serlo al no estarlo teniendo en cuenta habrán 
  // resultados inesperados.
  static $db_workers = 0;
  
  public function __construct( $host, $user, $password, $db='' )
  {
    $this->db_object_abstraction = new mysqli( $host, $user, $password, $db );
    if($this->db_object_abstraction->connect_error){
      die("ERROR al tratar de conectar con la base de datos.\n");
    } else {
      StorageAdapter::$db_workers++;
    }
  }

  public function findHotelsAndApartments( $match )
  {
    $columna = key($match);
    $valor = '%'.$match[$columna].'%';

    $resultado = $this->db_object_abstraction->query(sprintf("
      (
        SELECT nombre,numero_estrellas,tipo_habitacion,ciudad,provincia 
        FROM hoteles
        WHERE %s LIKE '%s' 
      ) UNION (
        SELECT nombre,apartamentos_disponibles,capacidad_adultos,ciudad,provincia 
        FROM apartamentos 
        WHERE %s LIKE '%s'
      ) ORDER BY nombre ASC
    ", $columna,$valor,$columna,$valor));

    // Si hubo un error devolvemos false.
    if( false == $resultado ) { 
      // print "\nLa tabla o la columna que se trata buscar no existen"; 
      return false;
    }

    $resultado = $resultado->fetch_all();

    // Si no hubieron resultados devolvemos null.
    if( NULL == $resultado){ return NULL; }
    
    return $resultado;
  }

  public function get_db_object() { return $this->db_object_abstraction; }

}
