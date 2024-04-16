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
  <title>Exercícios de Internet - Prof. Alecx</title>
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
<div class="container-text">
  <br>
  <br>
  <h1>Explorando o Mundo Digital: Um Guia para Navegação na Internet</h1>
  <p>A Internet é uma rede global de computadores interconectados, criando um vasto mundo digital onde bilhões de pessoas podem se conectar, compartilhar informações e acessar recursos de forma instantânea. Para explorar esse universo, é essencial entender alguns conceitos-chave e ferramentas fundamentais.</p>
  
  <h2>O navegador da web</h2>
  <p>O navegador da web é a porta de entrada para esse mundo digital. Como um navegador de internet, você pode acessar uma variedade de páginas da web e recursos online. Ele interpreta os códigos das páginas, como HTML e CSS, e os exibe em formatos compreensíveis para os usuários. Navegadores populares incluem o Google Chrome, Mozilla Firefox e Safari.</p>
  
  <h2>O endereço de site</h2>
  <p>Para chegar a um destino específico na Internet, você precisa de um endereço de site, também conhecido como URL. Assim como um endereço físico leva você a um lugar específico na cidade, um URL leva você a uma página específica na web. Digitando o URL na barra de endereço do navegador, você pode acessar sites, blogs, lojas online e muito mais.</p>
  
  <h2>O email</h2>
  <p>O email é uma ferramenta de comunicação essencial na Internet. Ele permite enviar mensagens digitais para uma ou várias pessoas instantaneamente. Além de mensagens de texto, você pode enviar e receber anexos, como documentos, imagens e vídeos, tornando-o uma ferramenta versátil para comunicação pessoal e profissional.</p>

  <h2>Segurança na Internet</h2>
  <p>Quando navegamos na Internet, a segurança é uma preocupação importante. Uma maneira de verificar se uma página é segura é procurar pelo ícone de um cadeado na barra de endereço do navegador. Esse cadeado indica que a conexão entre o seu navegador e o site é criptografada, protegendo assim suas informações pessoais e financeiras contra hackers e ataques cibernéticos.</p>
  
  <h2>Explorando as Possibilidades</h2>
  <p>A Internet oferece uma infinidade de possibilidades. Você pode usá-la para se conectar com amigos e familiares em redes sociais, pesquisar informações sobre qualquer assunto, assistir a vídeos e filmes, ouvir música, jogar jogos online, fazer compras e muito mais. Acessível por meio de dispositivos como computadores, smartphones e tablets, a Internet se tornou uma parte integrante da vida moderna.</p>
  
  <h2>Os sites</h2>
  <p>Os sites são os edifícios dessa cidade digital. Eles são conjuntos de páginas da web relacionadas entre si, organizadas em torno de um tema ou propósito comum. Os sites podem conter uma variedade de conteúdos, como texto, imagens, vídeos, formulários interativos e muito mais, proporcionando uma experiência rica e envolvente para os usuários.</p>
  
  <p>Em resumo, a Internet é um vasto universo digital repleto de oportunidades e recursos. Com o navegador certo e um pouco de conhecimento, você pode explorar esse mundo digital e aproveitar ao máximo tudo o que ele tem a oferecer.</p>
</div>



  <div class="container mt-5">
    <div class="jumbotron">
      <h1 class="display-4"><i class="fas fa-globe"></i> Exercícios de Internet</h1>
      <p class="lead">Pratique seus conhecimentos sobre Internet com estes exercícios básicos.</p>
    </div>

    <form id="exercise-form">
      <div class="exercise">
        <h2>Exercício 1</h2>
        <p>O que é a Internet?</p>
        <ol>
          <li><input type="radio" name="question1" value="a"> Um tipo de computador</li>
          <li><input type="radio" name="question1" value="b"> Um lugar para fazer compras</li>
          <li><input type="radio" name="question1" value="c"> Uma rede de computadores que se conectam</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 2</h2>
        <p>Para que serve o navegador da web?</p>
        <ol>
          <li><input type="radio" name="question2" value="a"> Para fazer chamadas telefônicas</li>
          <li><input type="radio" name="question2" value="b"> Para acessar e ver páginas na Internet</li>
          <li><input type="radio" name="question2" value="c"> Para cozinhar comida</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 3</h2>
        <p>O que é um endereço de site?</p>
        <ol>
          <li><input type="radio" name="question3" value="a"> Um número de telefone</li>
          <li><input type="radio" name="question3" value="b"> Um identificador único para uma página na Internet</li>
          <li><input type="radio" name="question3" value="c"> O endereço de casa de alguém</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 4</h2>
        <p>Para que serve um email?</p>
        <ol>
          <li><input type="radio" name="question4" value="a"> Para jogar videogames</li>
          <li><input type="radio" name="question4" value="b"> Para enviar mensagens pela Internet</li>
          <li><input type="radio" name="question4" value="c"> Para cozinhar receitas</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 5</h2>
        <p>Como você pode saber se uma página está segura para navegar?</p>
        <ol>
          <li><input type="radio" name="question5" value="a"> Verificando o ícone de cadeado na barra de endereço</li>
          <li><input type="radio" name="question5" value="b"> Pedindo permissão para um amigo</li>
          <li><input type="radio" name="question5" value="c"> Procurando fotos bonitas</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 6</h2>
        <p>Qual é o principal uso da Internet?</p>
        <ol>
          <li><input type="radio" name="question6" value="a"> Assistir TV</li>
          <li><input type="radio" name="question6" value="b"> Enviar emails</li>
          <li><input type="radio" name="question6" value="c"> Acessar informações e comunicar com outras pessoas</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 7</h2>
        <p>Como você pode acessar a Internet?</p>
        <ol>
          <li><input type="radio" name="question7" value="a"> Através de um telefone</li>
          <li><input type="radio" name="question7" value="b"> Através de um computador ou celular conectado à rede</li>
          <li><input type="radio" name="question7" value="c"> Através de uma máquina de lavar roupas</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 8</h2>
        <p>O que você pode fazer na Internet?</p>
        <ol>
          <li><input type="radio" name="question8" value="a"> Aprender novas habilidades, fazer compras, conversar com amigos</li>
          <li><input type="radio" name="question8" value="b"> Andar de bicicleta</li>
          <li><input type="radio" name="question8" value="c"> Pintar quadros</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 9</h2>
        <p>O que é um site?</p>
        <ol>
          <li><input type="radio" name="question9" value="a"> Um tipo de comida</li>
          <li><input type="radio" name="question9" value="b"> Uma página ou conjunto de páginas na Internet</li>
          <li><input type="radio" name="question9" value="c"> Um tipo de música</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 10</h2>
        <p>O que é um navegador de Internet?</p>
        <ol>
          <li><input type="radio" name="question10" value="a"> Uma pessoa que gosta de nadar na praia</li>
          <li><input type="radio" name="question10" value="b"> Um programa de computador que permite acessar e visualizar páginas na Internet</li>
          <li><input type="radio" name="question10" value="c"> Uma máquina de café</li>
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
      if (form.question2.value === 'b') {
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
      if (form.question5.value === 'a') {
        pontuacao++;
        respostasCorretas.push('Exercício 5');
      }
      if (form.question6.value === 'c') {
        pontuacao++;
        respostasCorretas.push('Exercício 6');
      }
      if (form.question7.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 7');
      }
      if (form.question8.value === 'a') {
        pontuacao++;
        respostasCorretas.push('Exercício 8');
      }
      if (form.question9.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 9');
      }
      if (form.question10.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 10');
      }

      // Exibir resultados
      document.getElementById('pontuacao').textContent = pontuacao + '/' + 10;
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
