-- Tanto crear las tablas como importar los datos desde los archivos csv
-- podria automatizarse con los datos de DatabaseMapper

USE db_hospedajes;
LOAD DATA LOCAL INFILE './import/csv_import_files/hoteles.csv' REPLACE INTO TABLE hoteles
  CHARACTER SET utf8mb4
  FIELDS TERMINATED BY ',' 
  ENCLOSED BY '"' 
  LINES TERMINATED BY '\n'
  ( nombre, numero_estrellas, tipo_habitacion, ciudad, provincia );
LOAD DATA LOCAL INFILE './import/csv_import_files/apartamentos.csv' REPLACE INTO TABLE apartamentos
  CHARACTER SET utf8mb4
  FIELDS TERMINATED BY ',' 
  ENCLOSED BY '"' 
  LINES TERMINATED BY '\n'
  ( nombre, apartamentos_disponibles, capacidad_adultos, ciudad, provincia );
