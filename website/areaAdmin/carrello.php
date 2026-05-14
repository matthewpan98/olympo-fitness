<?php
    require_once "../connection.php";
    require_once "../funzioni.php";


    use DB\DBAccess;
    session_start();
    setlocale(LC_ALL, 'it_IT');

    $connection = new DBAccess();
    
    $paginaHTML = file_get_contents('templates/carrelloTemplate.html');

    $stringaMessaggio = "";

    if($connection->isLoggedInAdmin()){ //admin non può comprare
        $stringaMessaggio = '<p class="error_Message">Questa pagina non è disponibile perché sei collegato con l\'<span lang="en">account</span> amministratore. Per regola, un amministratore non può usufruire del carrello. Ti preghiamo di accedere con un <span lang="en">account</span> utente.</p>';
    }
    else{ //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }
    $paginaHTML = str_replace("{errori}",$stringaMessaggio,$paginaHTML);

    echo $paginaHTML;

?>