<?php
require_once "../connection.php";
require_once "../funzioni.php";


use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');
session_start();

$paginaHTML = file_get_contents("templates/faqTemplate.html");

$connection = new DBAccess();
$errori = "";
$domanda = "";
$utenteID = "";

if($connection->isLoggedInUser()){
    
    if(isset($_POST['addQuestion'])){

        $domanda = sanitizeInput($_POST['question']);

        if(strlen($domanda)<5){
            $errori = '<p class="error_Message" role="alert">Inserire una domanda superiore ai 5 caratteri</p>';
        }
            $utenteID = $_SESSION['user'];
            
        if(empty($errori)){

            if($connection->openDBConnection()) {
                $query = "";
                $query = "INSERT INTO faq(domanda, utente) VALUES ('$domanda', $utenteID);";

                $checkQuery=$connection->modifyDatabase($query);
                $connection->closeDBConnection();

                if($checkQuery){
                    $errori ='<p class="success_Message" role="alert">Domanda consegnata con successo</p>';  
                }else{
                    $errori ='<p class="error_Message" role="alert">Non è stato possibile inviare la tua domanda. Per favore riprovare. Se l\'errore sussiste non esistare a contattarci tramite la nostra <span lang="en">email</span></p>';  
                }
            }else{
                $errori = DBConnectionError(true);
                $paginaHTML = str_replace("{erroriDomanda}",$errori,$paginaHTML);
            }
        }else{
            $paginaHTML = str_replace("{erroriDomanda}",$errori,$paginaHTML);
        }
    }
    $paginaHTML = str_replace("{erroriDomanda}",$errori,$paginaHTML);
}else{
    //ridirezionamento fuori areaUtente
    header("Location: ../index.php"); 
    die();
}

echo $paginaHTML;

?>
