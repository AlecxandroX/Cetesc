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
  <title>Exercícios de Excel - Prof. Alecx</title>
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
  
  <h1>Explorando o Mundo do Excel: Uma Jornada de Descobertas</h1>

<p>Dentro do vasto universo do Excel, cada célula é como um pequeno fragmento de potencial, esperando para ser preenchido com dados ou fórmulas. Imagine-o como um vasto quadro em branco, pronto para receber suas ideias e cálculos mais complexos.</p>


<p>Uma célula, na linguagem do Excel, é mais do que apenas um espaço vazio. É onde a mágica acontece. Aqui, você pode inserir números, texto ou até mesmo fórmulas complicadas para realizar cálculos sofisticados. Portanto, esqueça os gráficos de pizza e concentre-se no poder das células.</p>

<p>E falando em fórmulas, elas são o coração pulsante do Excel. Não se trata apenas de estilos de formatação ou tipos de gráficos. As fórmulas são como instruções mágicas que o Excel segue para realizar todos os tipos de cálculos, desde somar números até encontrar o maior valor em um conjunto de dados.</p>

<p>E quando se trata de somar um intervalo de células, não há dúvida de que a função correta é =SOMA(). É como se você estivesse dando ao Excel uma ordem para adicionar todos os números juntos em um instante.</p>

<p>E como podemos esquecer da largura das colunas? É possível ajustá-las com facilidade, simplesmente clicando e arrastando suas bordas. Nada de complicação aqui, apenas a liberdade de personalizar sua planilha como desejar.</p>

<p>Ah, as planilhas! Elas são como o pano de fundo de todo esse cenário. Uma planilha no Excel é onde você pode organizar e manipular seus dados de maneira clara e eficiente, com linhas e colunas agindo como os blocos de construção de suas ideias.</p>
<p>
Para fazer uma divisão no Excel, você pode usar o operador de divisão (/) ou a função DIVIDIR. Com o operador de divisão, você digita a fórmula com a referência do dividendo, seguido pelo sinal de divisão (/) e a referência do divisor. Com a função DIVIDIR, você digita "=DIVIDIR(" seguido pelas referências do dividendo e do divisor, e fecha os parênteses.</p>

<p>E quando você precisa recalcular todas as fórmulas, basta pressionar a tecla F9. É como um botão de reinicialização que garante que tudo esteja atualizado e pronto para ir.</p>

<p>E para exibir valores como moeda, basta selecionar a célula e escolher o formato desejado. É simples assim, sem complicações.</p>

<p>E quando se trata de juntar diferentes palavras ou strings, a função =CONCATENAR() é sua melhor amiga. Ela une tudo em uma única frase coesa, pronta para impressionar.</p>

<p>E se você precisar adicionar uma nova linha ou coluna ao seu arquivo, é tão fácil quanto clicar com o botão direito em uma celula existente e selecionar "Inserir" e depois "colula" ou "linha"(em cima ou em baixo, a direita ou a esquerda). Uma nova linha ou coluna em branco surgira para suas ideias brilhantes.</p>

<p>Então, mergulhe de cabeça no mundo do Excel. Explore, experimente e descubra todas as maravilhas que ele tem a oferecer. E lembre-se, as possibilidades são infinitas.</p>

</div>
  <div class="container mt-5">
    <div class="jumbotron">
      <h1 class="display-4"><i class="fas fa-globe"></i> Exercícios de Excel</h1>
      <p class="lead">Pratique seus conhecimentos sobre Excel com estes exercícios básicos.</p>
    </div>

    <form id="exercise-form">
      <div class="exercise">
        <h2>Exercício 1</h2>
        <p>O que é uma célula no Excel?</p>
        <ol>
          <li><input type="radio" name="question1" value="a"> Um gráfico de pizza</li>
          <li><input type="radio" name="question1" value="b"> Um local onde você pode digitar texto</li>
          <li><input type="radio" name="question1" value="c"> Um local onde você pode inserir dados ou fórmulas</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 2</h2>
        <p>O que é uma fórmula no Excel?</p>
        <ol>
          <li><input type="radio" name="question2" value="a"> Um estilo de formatação</li>
          <li><input type="radio" name="question2" value="b"> Um tipo de gráfico</li>
          <li><input type="radio" name="question2" value="c"> Uma expressão que realiza cálculos em valores nas células</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 3</h2>
        <p>Qual função é usada para somar um intervalo de células no Excel?</p>
        <ol>
          <li><input type="radio" name="question3" value="a"> =MULTIPLICAR()</li>
          <li><input type="radio" name="question3" value="b"> =CONCATENAR()</li>
          <li><input type="radio" name="question3" value="c"> =SOMA()</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 4</h2>
        <p>Como você pode alterar a largura de uma coluna no Excel?</p>
        <ol>
          <li><input type="radio" name="question4" value="a"> Clicando e arrastando a borda da coluna</li>
          <li><input type="radio" name="question4" value="b"> Digitando a largura desejada em uma caixa de texto</li>
          <li><input type="radio" name="question4" value="c"> Não é possível alterar a largura das colunas no Excel</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 5</h2>
        <p>O que é uma planilha no Excel?</p>
        <ol>
          <li><input type="radio" name="question5" value="a"> Um tipo de gráfico de linha</li>
          <li><input type="radio" name="question5" value="b"> Uma área onde você pode inserir e manipular dados organizados em linhas e colunas</li>
          <li><input type="radio" name="question5" value="c"> Um tipo de função</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 6</h2>
        <p>Qual tecla de atalho é usada para recalcular todas as fórmulas no Excel?</p>
        <ol>
          <li><input type="radio" name="question6" value="a"> F1</li>
          <li><input type="radio" name="question6" value="b"> F9</li>
          <li><input type="radio" name="question6" value="c"> F5</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 7</h2>
        <p>Qual função você usaria para encontrar o maior valor em um conjunto de células no Excel?</p>
        <ol>
          <li><input type="radio" name="question7" value="a"> =MÁXIMO()</li>
          <li><input type="radio" name="question7" value="b"> =MÉDIA()</li>
          <li><input type="radio" name="question7" value="c"> =MÍNIMO()</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 8</h2>
        <p>Como você pode formatar uma célula para exibir valores como moeda?</p>
        <ol>
          <li><input type="radio" name="question8" value="a"> Não é possível formatar células para exibir valores como moeda</li>
          <li><input type="radio" name="question8" value="b"> Selecionando a célula e clicando em "Formatar celula" e escolhendo a opção "Moeda"</li>
          <li><input type="radio" name="question8" value="c"> Digitando "R$" antes dos valores na célula</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 9</h2>
        <p>Qual função é usada para divisão  no Excel?</p>
        <ol>
          <li><input type="radio" name="question9" value="a"> =SOMA()</li>
          <li><input type="radio" name="question9" value="b"> =Valor1/Valor2</li>
          <li><input type="radio" name="question9" value="c"> =MÉDIA()</li>
        </ol>
      </div>

      <div class="exercise">
        <h2>Exercício 10</h2>
        <p>Como você pode inserir uma nova linha ou coluna  em um arquivo do Excel?</p>
        <ol>
          <li><input type="radio" name="question10" value="a"> Não é possível inserir uma nova planilha em um arquivo do Excel</li>
          <li><input type="radio" name="question10" value="b"> Clicando com o botão direito em uma celula existente e selecionando "Inserir" e depois "linha" ou coluna</li>
          <li><input type="radio" name="question10" value="c"> Digitando "=NOVAPLANILHA()" em uma célula</li>
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
      if (form.question2.value === 'c') {
        pontuacao++;
        respostasCorretas.push('Exercício 2');
      }
      if (form.question3.value === 'c') {
        pontuacao++;
        respostasCorretas.push('Exercício 3');
      }
      if (form.question4.value === 'a') {
        pontuacao++;
        respostasCorretas.push('Exercício 4');
      }
      if (form.question5.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 5');
      }
      if (form.question6.value === 'b') {
        pontuacao++;
        respostasCorretas.push('Exercício 6');
      }
      if (form.question7.value === 'a') {
        pontuacao++;
        respostasCorretas.push('Exercício 7');
      }
      if (form.question8.value === 'b') {
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
