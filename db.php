<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "curso";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida
if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
} 
?>
