<?php
require_once "../connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');
session_start();

$paginaHTML = file_get_contents("templates/faqTemplate.html");

$connection = new DBAccess();
$question = "";

if($connection->isLoggedInAdmin()){

    $question = '<p>Sei collegato come amministratore, di conseguenza non puoi inviare alcuna domanda</p>';
    $paginaHTML = str_replace("{erroriDomanda}", $question, $paginaHTML);
    
}else{
    //ridirezionamento fuori areaAdmin
    header("Location: ../index.php");
    die();
}

echo $paginaHTML;


?>
