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
  <title>Exercícios de PowerPoint - Prof. Alecx</title>
  <!-- Adicionando Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Adicionando Font Awesome (para ícones) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Adicionando CSS personalizado -->
  <link rel="stylesheet" href="estilo.css">
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

  <div class="container mt-5">
    <div class="jumbotron">
      <h1 class="display-4"><i class="fas fa-globe"></i> Exercícios de PowerPoint</h1>
      <p class="lead">Pratique seus conhecimentos sobre o Microsoft PowerPoint com estes exercícios básicos.</p>
    </div>

    <form id="exercise-form">
      <div class="exercise">
        <h2>Exercício 1</h2>
        <p>O que é o Microsoft PowerPoint?</p>
        <ol>
          <li><input type="radio" name="question1" value="a"> Um programa de edição de imagens</li>
          <li><input type="radio" name="question1" value="b"> Um programa para criar planilhas</li>
          <li><input type="radio" name="question1" value="c"> Um programa para criar apresentações de slides</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 2</h2>
        <p>Qual é a extensão padrão dos arquivos do Microsoft PowerPoint?</p>
        <ol>
          <li><input type="radio" name="question2" value="a"> .pptx</li>
          <li><input type="radio" name="question2" value="b"> .docx</li>
          <li><input type="radio" name="question2" value="c"> .xlsx</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 3</h2>
        <p>O que são slides no PowerPoint?</p>
        <ol>
          <li><input type="radio" name="question3" value="a"> Um tipo de efeito de transição</li>
          <li><input type="radio" name="question3" value="b"> Páginas individuais em uma apresentação</li>
          <li><input type="radio" name="question3" value="c"> O nome de uma ferramenta de desenho</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 4</h2>
        <p>O que é um modelo de design no PowerPoint?</p>
        <ol>
          <li><input type="radio" name="question4" value="a"> Um tipo de animação de texto</li>
          <li><input type="radio" name="question4" value="b"> Um padrão de formatação de slides</li>
          <li><input type="radio" name="question4" value="c"> Um tipo de música de fundo para a apresentação</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 5</h2>
        <p>Qual é a função do botão "Inserir Imagem" no PowerPoint?</p>
        <ol>
          <li><input type="radio" name="question5" value="a"> Adicionar uma nova página à apresentação</li>
          <li><input type="radio" name="question5" value="b"> Inserir uma imagem de arquivo em um slide</li>
          <li><input type="radio" name="question5" value="c"> Alterar o plano de fundo do slide</li>
        </ol>
      </div>

      <button type="button" class="btn btn-primary" onclick="verificarRespostas()">Verificar Respostas</button>
    </form>

    <div id="resultado" class="mt-4" style="display: none;">
      <h2>Resultado</h2>
      <p>Sua pontuação: <span id="pontuacao"></span></p>
      <p>Respostas corretas:</p>
      <ul id="respostas-corretas"></ul>
    </div>
  </div>

  <!-- Adicionando Bootstrap JavaScript (opcional) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Adicionando Font Awesome (para ícones) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

  <script>
    function verificarRespostas() {
      var form = document.getElementById('exercise-form');
      var pontuacao = 0;
      var respostasCorretas = [];

      // Verifica as respostas
      if (form.question1.value === 'c') {
        pontuacao++;
        respostasCorretas.push('Exercício 1');
      }
      if (form.question2.value === 'a') {
        pontuacao++;
        respostasCorretas.push('Exercício 2');
      }
      if (form.question3.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 3');
      }
      if (form.question4.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 4');
      }
      if (form.question5.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 5');
      }

      // Exibir resultados
      document.getElementById('pontuacao').textContent = pontuacao + '/' + 5;
      document.getElementById('respostas-corretas').innerHTML = '';
      for (var i = 0; i < respostasCorretas.length; i++) {
        var li = document.createElement('li');
        li.textContent = respostasCorretas[i];
        document.getElementById('respostas-corretas').appendChild(li);
      }
      document.getElementById('resultado').style.display = 'block';
    }
  </script>
</body>
</html>
