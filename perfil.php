<?php
// Iniciar sessão
session_start();

// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "curso";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para limpar os dados
function limpar_dados($dados) {
    return htmlspecialchars(stripslashes(trim($dados)));
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpa e obtém os dados do formulário
    $username = limpar_dados($_POST['username']);
    $password = limpar_dados($_POST['password']);
    $name = limpar_dados($_POST['name']);
    
    // Verifica se uma nova foto foi enviada
    if ($_FILES['foto']['size'] > 0) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $sql = "UPDATE users SET password='$password', name='$name', foto_coluna='$foto' WHERE username='$username'";
    } else {
        $sql = "UPDATE users SET password='$password', name='$name' WHERE username='$username'";
    }
    
    // Executa a consulta de atualização
    if ($conn->query($sql) === TRUE) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar dados: " . $conn->error;
    }
}

// Verifica se o nome de usuário está definido na sessão
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Carrega os dados do usuário
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Nenhum usuário encontrado.";
        exit;
    }
} else {
    echo "Nome de usuário não encontrado na sessão.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <!-- Adicionando Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Adicionando Font Awesome (para ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Adicionando CSS personalizado -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
        }
        h2 {
            color: #343a40;
            margin-bottom: 30px;
            text-align: center;
        }
        form input[type="password"],
        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form img {
            display: block;
            margin: 20px auto;
            border-radius: 5px;
            box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.2);
        }
        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-user-edit"></i> Editar Usuário</h2>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Nova Senha:</label>
                <input type="password" class="form-control" name="password" id="password" value="<?php echo $row['password']; ?>">
            </div>
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Nome:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo $row['name']; ?>">
            </div>
            <div class="form-group">
                <label for="foto"><i class="fas fa-camera"></i> Foto de Perfil:</label>
                <input type="file" class="form-control-file" name="foto" id="foto">
            </div>
            <?php if (!empty($row['foto_coluna'])) { ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto_coluna']); ?>" class="img-fluid" width="150" height="150" alt="Foto de Perfil">
            <?php } ?>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Alterações</button>
        </form>
    </div>

    <!-- Adicionando Bootstrap JavaScript (opcional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
