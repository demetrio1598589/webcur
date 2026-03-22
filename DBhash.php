<?php
// Contraseña de ejemplo que tienes en tu DB
$password_plana = '123';

// Generar el hash seguro (Algoritmo Bcrypt)
$password_segura = password_hash($password_plana, PASSWORD_BCRYPT);

echo "Copia este hash en tu base de datos:\n";
echo $password_segura . "\n";
?>