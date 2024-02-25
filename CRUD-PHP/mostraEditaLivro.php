<?php

$index  = $_POST['index'];
$titulo = $_POST['titulo'];
$autor  = $_POST['autor'];

$template = file_get_contents('editarLivro.html');

$template = str_replace('{ID}', $index, $template);
$template = str_replace('{TITULO}', $titulo, $template);
$template = str_replace('{AUTOR}', $autor, $template);

echo $template;
