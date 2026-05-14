<?php
require_once "../connection.php";
use DB\DBAccess;
session_start();

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/macchinariTemplate.html");
$stringaMacchine = "";
$listaMacchine = "";

$connection = new DBAccess();

if($connection->isLoggedInUser()){
    $stringaMacchine = '<ul id="products_Container">';
    if ($connection->openDBConnection()) {
        $listaMacchine = $connection->getMacchinariFromDatabase();
        $connection->closeDBConnection();

        if ($listaMacchine != null) {
            foreach ($listaMacchine as $macchine) {
                $stringaMacchine .= '<li><a href="prodotto.php?id=' . $macchine["ID"] . '"><img src="../' . $macchine["immagine1"] . '" alt="' . $macchine["alt"] . '"><p>' . $macchine["nome"] . ' - €' . $macchine["prezzo"] . '</p></a></li>';
            }
        }   else {
            $stringaMacchine .= "<li>Non sono presenti accessori</li>";
        }
    } else {
        $stringaMacchine .= "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
    }
        $stringaMacchine .= '</ul>';
}else{
    //ridirezionamento fuori areaUtente
    header("Location: ../index.php");
    die();
}

$paginaHTML = str_replace("{macchinari}", $stringaMacchine, $paginaHTML);
echo $paginaHTML;

?>