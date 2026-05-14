<?php
    require_once "../connection.php";
    use DB\DBAccess;
   
    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/rimuoviProdottoTemplate.html");
    $resultQuery = "";

    $connection = new DBAccess();
    
    if($connection->isLoggedInAdmin()){
        if($connection->openDBConnection()) {

        $form = "";

            $result = $connection->getProductsFromDatabase();
            $connection->closeDBconnection();

            if($result != null) {
                foreach($result as $prodotto){
                    $form .= '<option value=' .$prodotto['ID']. '>' . $prodotto['nome'] . '</option>';
                }
            }else{
                $form = '<option value="0" disabled>Non ci sono prodotti</option>';
            }


        if(isset($_POST["conferma"])) {
        if($result != null){
            $scelta_prodotto = $_POST["lista_prodotti"];
        
                if($connection->openDBConnection()){
                    $query = "";
                    $query = "DELETE FROM prodotto WHERE ID = $scelta_prodotto;";
                    $resultQuery = $connection->modifyDatabase($query);
                    $connection->closeDBconnection();

                    if($resultQuery){
                    $resultQuery = '<p class="success_Message" role="alert">Rimozione avvenuta con successo.</p>';
                    
                    if($connection->openDBConnection()) {
                
                        $form = "";
                                
                            $result = $connection->getProductsFromDatabase();
                            $connection->closeDBconnection();

                            if($result != null) {
                                foreach($result as $prodotto){
                                    $form .= '<option value=' .$prodotto['ID']. '>' . $prodotto['nome'] . '</option>';
                                }
                            }else{
                                $form = '<option value="0" disabled>Non ci sono prodotti</option>';
                            }
                        }else{
                            $stringaErrori = DBConnectionError(true);
                        }
                    }else{
                        $resultQuery = '<p class="error_Message" role="alert">Fallito il tentativo di rimuovere il prodotto selezionato.</p>';
                    }
                }else{
                    $stringaErrori = DBConnectionError(true);
                }
        }else{
            $stringaErrori = '<p class="error_Message" role="alert">Non ci sono più prodotti nel nostro sistema.</p>';
            $paginaHTML = str_replace("{risultatoQuery}",$stringaErrori,$paginaHTML);
        }
        }

        $paginaHTML = str_replace("{rimuovi}",$form,$paginaHTML); 
        $paginaHTML = str_replace("{risultatoQuery}",$resultQuery,$paginaHTML);
                                              
    }else{
        $stringaErrori = DBConnectionError(true);
        $paginaHTML = str_replace("{rimuovi}",$stringaErrori,$paginaHTML); 
    }
}else{
     //ridirezionamento fuori areaAdmin
     header("Location: ../index.php");
     die();
}

    echo $paginaHTML;
    
?>