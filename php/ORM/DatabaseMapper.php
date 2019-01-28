<?php

  namespace matcher\php\ORM;

/**
 *  Con esta clase abstracta pretendo hacer una suerte de ENUM que enumere
 *  los distintos tipos de datos que recoge la aplicacion para que a la hora
 *  de validar los datos cuando haya que insertarlos en la DB haya un menor margen
 *  de error.
 * */

abstract class DataTypes 
{
  const primKey = "PRIMARY KEY";
  const forKey = "FOREIGN KEY";
  const char = "CHAR";
  const varchar = "VARCHAR";
  const text = "TEXT";
  const password = "CHAR"; // Se le trata diferente porque hay que cifrarla antes de almacenarla a diferencia de otros chars
  const email = "VARCHAR"; // Debe ser un email valido
  const fecha = "DATE";
  const enum = "ENUM";
}

/**
 *  Esta clase (DatabaseMapper) es el núcleo de esta estructura.
 *
 *  Se encarga de digerir (sanitizar, validar, cifrar) los datos
 *  segun los requerimentos de cada tipo de dato y posteriormente
 *  decidir si mandarselos a StorageAdapter para que opere con esos
 *  datos sobre la base de datos o instanciarlos en un objeto Modelo 
 *  que represente el tipo de objeto/dato complejo en cuestión
 *  (Usuario, Articulo, ... ).
 *
 *  Los modelos tienen como unica finalidad representar los datos.
 */
class DatabaseMapper
{
  
  public $adapter;
  private static $tableName_to_object = array(
    'hoteles'    => 'Hotel',
    'apartamentos'     => 'Apartamento'
  );

  static $tables = array('hoteles','apartamentos');

  /**
   *  Estas variables *_columns nos ayudan a 2 cosas:
   *    1) definen cuales son las columnas validas para cada tabla,
   *    2) guardan el tipo de dato que almacenan para poder validar
   *         los datos antes de insertarlos en la tabla. 
   *         Podria tambien tenerse en cuenta la longitud de los
   *         valores u otras cosas pero no lo veo tan relevante para 
   *         este ejemplo, la estructura sin embargo seguiria siendo
   *         la misma.
   * */
  static $hoteles_columns = array(
    'id'                => DataTypes::primKey,
    'nombre'            => DataTypes::varchar,
    'numero_estrellas'  => DataTypes::enum,
    'tipo_habitacion'   => DataTypes::enum,
    'provincia'         => DataTypes::varchar,
    'ciudad'            => DataTypes::varchar
  );
  static $apartamentos_columns = array(
    'id'                        => DataTypes::primKey,
    'nombre'                    => DataTypes::varchar,
    'apartamentos_disponibles'  => DataTypes::varchar,
    'capacidad_adultos'         => DataTypes::varchar,
    'provincia'                 => DataTypes::varchar,
    'ciudad'                    => DataTypes::varchar
  );

  public function __construct( $storage )
  {
    $this->adapter = $storage;
  }

  /**
   * @param array $match Es un arreglo que usa su clave como nombre de la columna de la siguiente forma: array( 'nombre_columna' => 'valor' )
   * @param string table Es la tabla sobre la que realizar la consulta
   * @return  false si hay error
   *          NULL si no hubieron matches
   * */
  public function findHotelsAndApartments( $match, $table )
  {
    $resultado = $this->adapter->findHotelsAndApartments($match, $table);
    return $resultado;
  }

  public function mapToModel( $row, $table)
  {
   $tableName = trim(strtolower($table));
   $className = DatabaseMapper::$tableName_to_object[$tableName];
   // Esto no funcionaria en php5, habria que modificarlo.
   // return new $className(...array_values($row));
   return false;
  }

}
