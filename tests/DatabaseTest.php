<?php

declare(strict_types=1);

namespace matcher\tests;

use matcher\php\ORM\DatabaseMapper;
use matcher\php\ORM\StorageAdapter;
use matcher\credentials\credentials;
use PHPUnit\Framework\TestCase;

require __DIR__."/../php/ORM/DatabaseMapper.php";
require __DIR__ ."/../php/ORM/StorageAdapter.php";
require __DIR__ ."/../credentials/credentials.php";

final class DatabaseTest extends TestCase
{
  private static $db_mapper = NULL;
  private static $db_object_abstraction = NULL;

  public function testCanConnectToMysqlServer()
  {
    self::$db_mapper = new DatabaseMapper(new StorageAdapter(credentials::host, credentials::user, credentials::password));
    self::$db_object_abstraction = self::$db_mapper->adapter->get_db_object();
    self::$db_object_abstraction->select_db(credentials::database);
    return $this->assertAttributeEquals(0, "connect_errno", self::$db_object_abstraction);
  }
  public function testDatabaseExists()
  {
    return $this->assertTrue(self::$db_object_abstraction->select_db(credentials::database));
  }
  public function testDatabaseCharsetAcceptsMultilingualCharacters()
  {
    // utf8mb4 encoding accepts characters of all languages
    return $this->assertAttributeEquals('utf8mb4','charset',self::$db_object_abstraction->get_charset());
  }
  public function testAllNeededTablesExistAndThereAreNotUnexpectedTables()
  {
    $query = self::$db_object_abstraction->query("SHOW tables");
  
    $tables = array();

    // esto: $tables = $query->fetch_all();
    // devuelve un array de arrays, que no es lo que queremos.

    for ($i = 0; $i < $query->num_rows; $i++) {
      $tables[] = $query->fetch_row()[0];
    }
    $db_mapper_tables = self::$db_mapper::$tables;
    sort($db_mapper_tables);
    sort($tables);
    return $this->assertEquals($db_mapper_tables, $tables);
  }

  public function testColumnsOfAllTablesAreTheExpected()
  {
    $checks_results = array();    
    $all_true = array();
    foreach (self::$db_mapper::$tables as $tabla) {
      $query = self::$db_object_abstraction->query(sprintf("
        SELECT column_name FROM information_schema.columns WHERE 
          table_schema='%s' AND 
          table_name='%s'
        ",credentials::database,$tabla));
      $columns = array();
      for ($i = 0; $i < $query->num_rows; $i++) {
        $columns[] = $query->fetch_row()[0];
      }

      $mapper_columns = array_keys(self::$db_mapper::${$tabla.'_columns'});

      sort($mapper_columns);
      sort($columns);

      if ($mapper_columns != $columns){
        $checks_results[] = false;
      } else {
        $checks_results[] = true;
      }
      $all_true[] = true;
    }
    return $this->assertEquals($checks_results,$all_true);
  }
}
