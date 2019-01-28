#!/bin/bash

printf "\n\nEl instalador debe de ejecutarse desde la raiz del proyecto, esto es: ./install.sh\nNo debe ejecutarse de otra forma.\n\n"
printf "Usuario de la base de datos: "
read -r usuario
printf "Contraseña del usuario: "
read -r password

echo '<?php

namespace matcher\credentials;

/**
 * credenciales de conexion a la base de datos
 */
abstract class credentials
{
  const host = "localhost";
  const user = "usuario";
  const password = "password";
  const database = "db_hospedajes";
}' > ./credentials/credentials.php

exit

mysql -u $usuario -p$password < ./database/sql/delete_db.sql
mysql -u $usuario -p$password < ./database/sql/create_db.sql

cd database

mysql -u $usuario -p$password < ./import/import.sql

cd ..
composer install

sed -i 's/"host"/"localhost"/' ./credentials/credentials.php
sed -i 's/"usuario"/"'$usuario'"/' ./credentials/credentials.php
sed -i 's/"password"/"'$password'"/' ./credentials/credentials.php

./vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox ./tests/DatabaseTest
