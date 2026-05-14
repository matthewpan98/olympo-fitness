<?php
require_once "connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/accessoriTemplate.html");
$stringaAccessori = "";
$listaAccessori = "";

$connection = new DBAccess();

$stringaAccessori = '<ul id="products_Container">';

if ($connection->openDBConnection()) {
    $listaAccessori = $connection->getAccessoriFromDatabase();
    $connection->closeDBConnection();

    if ($listaAccessori != null) {
        foreach ($listaAccessori as $accessorio) {
            $stringaAccessori .= '<li><a href="prodotto.php?id=' . $accessorio["ID"] . '"><img src="' . $accessorio["immagine1"] . '" alt="' . $accessorio["alt"] . '"><p>' . $accessorio["nome"] . ' - €' . $accessorio["prezzo"] . '</p></a></li>';
        }
    } else {
        $stringaAccessori .= "<li>Non sono presenti accessori</li>";
    }
} else {
    $stringaAccessori .= "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}

$stringaAccessori .= '</ul>';


$paginaHTML = str_replace("{accessori}", $stringaAccessori, $paginaHTML);
echo $paginaHTML;


?>
