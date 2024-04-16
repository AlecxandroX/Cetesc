<?php

// Conecta ao banco de dados
$conn = mysqli_connect("localhost", "root", "", "curso");

// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
  // Recebe os dados do formulário
  $id = $_POST['id'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $foto_coluna = $_FILES['foto_coluna']['name'];

  // Verifica se a foto foi selecionada
  if ($foto_coluna != "") {
    // Move a foto para o diretório de uploads
    move_uploaded_file($_FILES['foto_coluna']['tmp_name'], "uploads/" . $foto_coluna);
  }

  // Prepara a consulta SQL para atualizar os dados do usuário
  $sql = "UPDATE users SET username=?, password=?, foto_coluna=? WHERE id=?";

  // Cria uma declaração preparada
  $stmt = mysqli_prepare($conn, $sql);

  // Vincula os parâmetros à declaração preparada
  mysqli_stmt_bind_param($stmt, "sssi", $username, $password, $foto_coluna, $id);

  // Executa a declaração preparada
  mysqli_stmt_execute($stmt);

  // Fecha a declaração preparada
  mysqli_stmt_close($stmt);

  // Redireciona para a página de perfil
  header("Location: perfil.php");
  exit;
}

// Seleciona os dados do usuário do banco de dados
$sql = "SELECT * FROM users WHERE id=?";

// Cria uma declaração preparada
$stmt = mysqli_prepare($conn, $sql);

// Vincula o parâmetro à declaração preparada
mysqli_stmt_bind_param($stmt, "i", $id);

// Executa a declaração preparada
mysqli_stmt_execute($stmt);

// Obtém o resultado da declaração preparada
$result = mysqli_stmt_get_result($stmt);

// Armazena os dados do usuário em uma variável
$user = mysqli_fetch_assoc($result);

// Fecha a declaração preparada
mysqli_stmt_close($stmt);

// Fecha a conexão com o banco de dados
mysqli_close($conn);

?>
