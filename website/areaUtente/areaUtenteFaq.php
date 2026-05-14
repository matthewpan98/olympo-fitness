<?php
require_once "../connection.php";
use DB\DBAccess;
session_start();


setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/areaUtenteFaqTemplate.html");

$stringaFAQ = "";
$listaFAQ = "";

$connection = new DBAccess();

if($connection->isLoggedInUser()){

if ($connection->openDBConnection()) {
    $id = $_SESSION['user'];
    $listaFAQ = $connection->getFaqFromDatabase($id);
    $connection->closeDBConnection();

    if ($listaFAQ != null) {
        foreach ($listaFAQ as $faq) {
            $stringaFAQ .= '<li class="q_a_box"><h3>Domanda: ' . $faq["domanda"] . '</h3><p>Risposta: ';
            if($faq["risposta"] != NULL){
                $stringaFAQ .= ''. $faq["risposta"] . '</p></li>';
            }else{
                $stringaFAQ .= 'L\'amministratore provvederà a rispondere il prima possibile</p></li>';
            }    
        }
    }else{
        $stringaFAQ = "<li>Non sono presenti domande</li>";
    }
} else {
    $stringaFAQ = "<li>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</li>";
}
}else{
    //ridirezionamento fuori areaUtente
    header("Location: ../index.php"); 
    die();
}

$paginaHTML = str_replace("{faq}", $stringaFAQ, $paginaHTML);
echo $paginaHTML;


?>
