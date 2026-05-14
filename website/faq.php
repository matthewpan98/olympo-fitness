<?php

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/faqTemplate.html");

$question = "";

$question = '<p>Per poter inviare una domanda è neccessario effettuare l\'accesso tramite la pagina <span lang="en">account</span>.</p>';

$paginaHTML = str_replace("{erroriDomanda}", $question, $paginaHTML);
echo $paginaHTML;

?>
