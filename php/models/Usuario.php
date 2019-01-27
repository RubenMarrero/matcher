<?php

namespace php\models;

  /**
  * Esta clase es un reflejo, o un modelo de un objeto Usuario 
  * almacenado en la base de datos.
  */
  class Usuario
  {

    private $id;                  //
    private $nombre_usuario;      //  Estas propiedades son privadas porque solo deben representar
    private $email;               //  los datos. Debemos de evitar que sean manipulables desde otros ambitos/objetos.
    private $idioma_preferido;    //
    private $fecha_creacion;      //

    /**
     * Al instanciar el objeto prescindimos de recoger la contraseña.
     * No la recogeremos a menos que sea estrictamente necesario, y 
     * en caso de hacerlo la manipularemos y/o mantendremos en memoria
     * durante el menor tiempo posible.
     * */    
    public function __construct($id, $nombre_usuario, $email, $idioma_preferido, $fecha_creacion) 
    {
      $this->id = $id;          
      $this->nombre_usuario = $nombre_usuario;
      $this->email = $email;
      $this->idioma_preferido = $idioma_preferido;
      $this->fecha_creacion = $fecha_creacion;          
    }

    public function getId() { return $this->id; }
    public function getNombreUsuario() { return $this->nombre_usuario; }
    public function getEmail() { return $this->email;  }
    public function getIdiomaPreferido() { return $this->idioma_preferido; }
    public function getFechaCreacion() { return $this->fecha_creacion; }

    public function get_modelo()
    {
      return array(
        "id"      => $this->id,
        "nombre"  => $this->nombre_usuario,
        "email"   => $this->email,
        "idioma_preferido"    => $this->idioma_preferido,
        "fecha_creacion"      => $this->fecha_creacion,
      );
    }

  }
