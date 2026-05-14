<?php
    require_once "../connection.php";
    require_once "../funzioni.php";

    use DB\DBAccess;
    $connection = new DBAccess();
    session_start();
    setlocale(LC_ALL, 'it_IT');

    $paginaHTML = file_get_contents('templates/loginTemplate.html');

    $stringaLogout = "";

    if($connection->isLoggedInUser()){

        $stringaLogout = '<p id="logout">Se vuoi disconnetterti premi il pulsante:</p> 
        <a href="logout.php" class="button">Esci</a>';
        $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
    
    }
    else{
        //ridirezionamento fuori areaUtente
        header("Location: ../index.php");
        die();
    }

    echo $paginaHTML;

?>
