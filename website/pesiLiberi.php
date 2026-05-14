<?php
require_once "connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/pesiLiberiTemplate.html");
$stringaPesiLiberi = "";
$listaPesiLiberi = "";

$connection = new DBAccess();

    $stringaPesiLiberi = '<ul id="products_Container">';
    if ($connection->openDBConnection()) {
        $listaPesiLiberi = $connection->getPesiLiberiFromDatabase();
        $connection->closeDBConnection();

        if ($listaPesiLiberi != null) {
            foreach ($listaPesiLiberi as $pesiLiberi) {
                $stringaPesiLiberi .= '<li><a href="prodotto.php?id=' . $pesiLiberi["ID"] . '"><img src="' . $pesiLiberi["immagine1"] . '" alt="' . $pesiLiberi["alt"] . '"><p>' . $pesiLiberi["nome"] . ' - €' . $pesiLiberi["prezzo"] . '</p></a></li>';
            }
        }else {
        $stringaPesiLiberi .= "<li>Non sono presenti pesi liberi</li>";
    }   
    }else {
        $stringaPesiLiberi .= "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
    }

    $stringaPesiLiberi .= '</ul>';

$paginaHTML = str_replace("{pesiLiberi}", $stringaPesiLiberi, $paginaHTML);
echo $paginaHTML;

?>
