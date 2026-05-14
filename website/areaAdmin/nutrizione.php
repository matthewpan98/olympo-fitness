<?php
require_once "../connection.php";
use DB\DBAccess;
session_start();

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/nutrizioneTemplate.html");
$stringaNutrizione = "";
$listaNutrizione = "";

$connection = new DBAccess();

if($connection->isLoggedInAdmin()){
    
    $stringaNutrizione = '<ul id="products_Container">';
    if($connection->openDBConnection()) {
        $listaNutrizione = $connection->getNutrizioneFromDatabase();
        $connection->closeDBConnection();

        if($listaNutrizione != null) {
            foreach ($listaNutrizione as $Nutrizione) {
                $stringaNutrizione .= '<li><a href="prodotto.php?id=' . $Nutrizione["ID"] . '"><img src="../' . $Nutrizione["immagine1"] . '" alt="' . $Nutrizione["alt"] . '"><p>' . $Nutrizione["nome"] . ' - €' . $Nutrizione["prezzo"] . '</p></a></li>';
            }
        }else {
            $stringaNutrizione .= "<li>Non sono presenti alimentari</li>";
        }
    } else {
        $stringaNutrizione .= "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
    }

    $stringaNutrizione .= "</ul>";

}else{
    //ridirezionamento fuori areaAdmin
    header("Location: ../index.php");
    die();
}




$paginaHTML = str_replace("{nutrizione}", $stringaNutrizione, $paginaHTML);
echo $paginaHTML;


?>
