<?php
session_start();
require_once "db.php";
include 'protect.php'; // Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login

// Verificando se o usuário está logado
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
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

// Verificar se o botão de logout foi acionado
if(isset($_POST['logout'])) {
  // Limpa a sessão
  session_unset();
  // Destrói a sessão
  session_destroy();
  // Redireciona para a página de login
  header("Location: login.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exercícios de Informática Básica - Prof. Alecx</title>
  <!-- Adicionando Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Adicionando Font Awesome (para ícones) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Adicionando CSS personalizado -->
 <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
    <a class="navbar-brand" href="dashboard.php"><i class="fas fa-laptop-code"></i> Exercícios de Informática Básica - Prof. Alecx</a>
        <div class="navbar-nav ml-auto">
            <span class="navbar-text">
                <span class="edit-profile" onclick="toggleEditProfile()">
                    <?php
                    if (!empty($row['foto_coluna'])) {
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['foto_coluna']).'" class="profile-picture" alt="Foto de Perfil">';
                    } else {
                        echo '<i class="fas fa-user-edit"></i>';
                    }
                    ?>
                    <?= $_SESSION['username']; ?>
                </span>
            </span>
        </div>
        
    </div>
    <form method="post">
  <button type="submit" name="logout" style="background-color: #f44336; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px;">
    <i class="fas fa-sign-out-alt" style="margin-right: 3px;"></i> Sair
  </button>
</form>

</nav>

<!-- Card de edição de perfil (inicialmente oculto) -->
<div class="card mt-3" id="editProfileCard" style="display: none;">
    <div class="card-header">
        <h5 class="card-title">Editar Perfil</h5>
    </div>
    <div class="card-body">
        
        <?php
        require_once "db.php"; // Arquivo com as configurações do banco de dados
        include 'protect.php'; // Include utilizado para não deixar o usuário entrar nas páginas sem utilizar o login
        
        // Verificando se o usuário está logado
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }
        
        // Verifica se o formulário foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Função para limpar os dados
            function limpar_dados($dados) {
                return htmlspecialchars(stripslashes(trim($dados)));
            }
        
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
    </div>
</div>

<script>
    function toggleEditProfile() {
        var editProfileCard = document.getElementById("editProfileCard");
        if (editProfileCard.style.display === "none") {
            editProfileCard.style.display = "block";
        } else {
            editProfileCard.style.display = "none";
        }
    }
</script>
 
  <div id="form" style="display: none;">
    <form action="upload.php" method="post" enctype="multipart/form-data">
      <input type="file" name="foto">
      <input type="submit" value="Enviar">
    </form>
  </div>

  <script>
    function toggleForm() {
      var form = document.getElementById("form");
      if (form.style.display === "none") {
        form.style.display = "block";
      } else {
        form.style.display = "none";
      }
    }
  </script>


  <div class="container mt-5">
    <div class="jumbotron">
      <h1 class="display-4"><i class="fas fa-graduation-cap"></i> Bem-vindo aos Exercícios de Informática Básica!</h1>
      <p class="lead">Eu sou o Prof. Alecx e estou aqui para ajudá-lo a aprender conceitos essenciais de informática de uma maneira prática e interativa.</p>
      <hr class="my-4">
      <p>Aqui você encontrará exercícios sobre diversos tópicos, incluindo Internet, Excel, Word, PowerPoint, Windows, WordPad e Calculadora.</p>
      <p>Escolha uma categoria abaixo para começar:</p>
      <div class="row">
        <div class="col-md-4">
          <a href="exercicio_internet.php" class="btn btn-primary"><i class="fas fa-globe"></i> Internet</a>
        </div>
        <div class="col-md-4">
          <a href="exercicio_excel.php" class="btn btn-primary"><i class="fas fa-table"></i> Excel</a>
        </div>
        <div class="col-md-4">
          <a href="exercicio_word.php" class="btn btn-primary"><i class="fas fa-file-word"></i> Word</a>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-4">
          <a href="exercicio_powerpoint.php" class="btn btn-primary"><i class="fas fa-file-powerpoint"></i> PowerPoint</a>
        </div>
        <div class="col-md-4">
          <a href="exercicio_windows.php" class="btn btn-primary"><i class="fab fa-windows"></i> Windows</a>
        </div>
        <div class="col-md-4">
          <a href="exercicio_wordpad.php" class="btn btn-primary"><i class="fas fa-file-alt"></i> WordPad</a>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-4">
          <a href="exercicio_calculadora.php" class="btn btn-primary"><i class="fas fa-calculator"></i> Calculadora</a>
        </div>
      </div>
    </div>

    <div class="contact-form mt-5">
    <h2 class="mb-4"><i class="fas fa-envelope"></i> Entre em Contato</h2>
    <a href="https://api.whatsapp.com/send?phone=49998220444&text=Olá,%20estou%20entrando%20em%20contato%20através%20do%20seu%20site" class="btn btn-success"><i class="fab fa-whatsapp"></i> </a>
    <a href="https://www.linkedin.com/in/alecxandro-xavier-406a1a13a/" class="btn btn-info"><i class="fab fa-linkedin"></i> </a>
    <a href="https://www.instagram.com/alecx_xavier" class="btn btn-info"><i class="fab fa-instagram"></i> </a>
</div>




  


  <!-- Adicionando Bootstrap JavaScript (opcional) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Adicionando Font Awesome (para ícones) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
