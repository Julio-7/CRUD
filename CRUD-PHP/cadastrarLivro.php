<?php
// recebe às variáveis
$titulo = $_POST['titulo'];
$autor  = $_POST['autor'];

// titulo ; autor
$linha = $titulo . ';' . $autor . PHP_EOL;

// salva no arquivo
file_put_contents("biblioteca.csv", $linha, FILE_APPEND);

// lê o arquivo lista-livros.html
$template      = file_get_contents("lista-livros.html");
$templateLinha = file_get_contents("linha-tabela-livros.html");

// ler o arquivo de biblioteca.csv
$livros = file("biblioteca.csv");
$linhas = '';
for ($i = 0; $i < count($livros); $i++) {
  // separando o que é titulo o que é autor
  $dadosArquivo = explode(';', $livros[$i]);
  if (isset($dadosArquivo[0]) && isset($dadosArquivo[1])) {
    $titulo = $dadosArquivo[0];
    $autor  = $dadosArquivo[1];
  } else {
    // vai ignorar tudo que está em baixo e vai para próxima linha
    continue;
  }
  // faz uma cópia do $templateLinha
  $linha = $templateLinha;

  // procura o ID e troca pelo posição do array
  $linha   = str_replace('{ID}', $i, $linha);
  // procura o AUTOR e troca pelo autor do livro
  $linha   = str_replace('{AUTOR}', $autor, $linha);
  // procura o TITULO e troca pelo titulo do livro
  $linha   = str_replace('{TITULO}', $titulo, $linha);

  $linhas .= $linha;
}

$template = str_replace("{LINHAS}", $linhas, $template);

// escreve o template como resposta
echo $template;
