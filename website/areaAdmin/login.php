<?php
    require_once "../connection.php";
    require_once "../funzioni.php";
   

    use DB\DBAccess;
    session_start();
    $connection = new DBAccess();
    setlocale(LC_ALL, 'it_IT');

    $stringaLogout = "";
    $paginaHTML     = file_get_contents('templates/loginTemplate.html');

    if($connection->isLoggedInAdmin()){

        $stringaLogout = '<p id="logout">Se vuoi disconnetterti premi il pulsante:</p> 
        <a href="logout.php" class="button">Esci</a>';
        $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
    
    }
    else{
        //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }

    echo $paginaHTML;

?>