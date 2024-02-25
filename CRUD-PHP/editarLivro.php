<?php

$index  = $_POST['index'];
$titulo = $_POST['titulo'];
$autor  = $_POST['autor'];

if ($index >= 0) {

  // leio todos os livros para um array
  $livros = file('biblioteca.csv');

  // percorro o array procurando pelo item a ser apagado
  for ($i = 0; $i < count($livros); $i++) {
    if (intval($index) === $i) {
      $novaLinha = $titulo . ';' . $autor . PHP_EOL;
      $livros[$i] = $novaLinha;
      break;
    }
  }

  // preciso atualizar o arquivo biblioteca.csv
  $livrosAtualizados = '';
  for ($i = 0; $i <= count($livros); $i++) {
    if (isset($livros[$i])) {
      $livrosAtualizados .= $livros[$i];
    }
  }

  // atualizando/substituindo os valores
  file_put_contents('biblioteca.csv', $livrosAtualizados);
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
}
