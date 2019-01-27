<?php

namespace php\models;
/**
 * Objeto modelo de los articulos. Se construye mezclando
 * las tablas articulo con articulos_lang haciendo coincidir
 * articulos_lang.id_idioma con usuarios.idioma_preferido
 * del usuario que vaya a visualizar el articulo de esta forma:
 *
 * SELECT * FROM articulos
 * INNER JOIN articulos_lang 
 * ON articulos.id=articulos_lang.id_articulo 
 * WHERE articulos_lang.id_idioma=$Usuario->idioma_preferido
 *
 */
class Articulo
{

  private $id;
  private $id_usuario; // Autor
  private $titulo;
  private $contenido;
  private $idioma;
  private $fecha_creacion;
  
  public function __construct($id, $id_usuario, $fecha_creacion)
  {
    $this->id = $id;
    $this->id_usuario = $id_usuario;
    $this->fecha_creacion = $fecha_creacion;
  }

  public function getId() { return $this->id; }
  public function getIdUsuario() { return $this->id_usuario; }
  public function getTitulo() { return $this->titulo; }
  public function getContenido() { return $this->contenido; }
  public function getIdioma() { return $this->idioma; }
  public function getFechaCreacion() { return $this->fecha_creacion; }
  public function get_modelo()
  {
    return array(
      "id"      => $this->id,
      "id_usuario"  => $this->id_usuario,
      "titulo"   => $this->titulo,
      "contenido"    => $this->contenido,
      "idioma"    => $this->idioma,
      "fecha_creacion"      => $this->fecha_creacion
    );
  }
  public function setContenido($id_idioma)
  {
    // recoger el contenido de articulos_lang
  }
}
