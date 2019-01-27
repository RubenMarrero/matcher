-- Tanto crear las tablas como importar los datos desde los archivos csv
-- podria automatizarse con los datos de DatabaseMapper

CREATE DATABASE IF NOT EXISTS db_hospedajes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_hospedajes;

CREATE TABLE hoteles (
  id INT AUTO_INCREMENT,
  nombre VARCHAR(30),
  numero_estrellas ENUM('1 estrella','2 estrellas','3 estrellas','4 estrellas', '5 estrellas'),
  tipo_habitacion ENUM('habitación doble','habitación simple','habitación doble con televisor', 'habitación simple con televisor'),
  ciudad VARCHAR(30),
  provincia VARCHAR(30),
  PRIMARY KEY(id)
);

CREATE TABLE apartamentos (
  id INT AUTO_INCREMENT,
  nombre VARCHAR(30),
  apartamentos_disponibles VARCHAR(30),
  capacidad_adultos VARCHAR(15),
  ciudad VARCHAR(15),
  provincia VARCHAR(15),
  PRIMARY KEY(id)
);


