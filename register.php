<?php
// Configuração do banco de dados (substitua com suas próprias informações)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'curso';

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $database);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Processa o formulário de registro quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];

    // Verifica se o usuário já existe
    $check_query = "SELECT * FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        echo "Esse nome de usuario ja existe.";
    } else {
        // Insere o novo usuário no banco de dados
        $insert_query = "INSERT INTO users (username, password, name) VALUES ('$username', '$password', '$name')";
        if ($conn->query($insert_query) === TRUE) {
            echo "Registration successful!";
            header("refresh:2; url=login.php");
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuários</title>
  <!-- Adicionando Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Adicionando Font Awesome (para ícones) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Adicionando CSS personalizado -->
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-image: url('login.jpg');
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      max-width: 400px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      padding: 40px;
    }

    .container h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #007bff;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-control {
      border-radius: 20px;
    }

    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      font-size: 1rem;
      padding: 10px 20px;
      border-radius: 20px;
      width: 100%;
      display: block;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }

    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1 class="display-4">Cadastro de Usuários</h1>
    <form action="register.php" method="post">
      <div class="form-group">
        <label for="username">Nome de usuário</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Digite seu nome de usuário">
      </div>
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha">
      </div>
      <div class="form-group">
        <label for="name">Nome completo</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome completo">
      </div>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
  </div>

</body>
</html>
