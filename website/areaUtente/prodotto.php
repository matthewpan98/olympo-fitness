<?php
require_once "../connection.php";
use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

session_start();

$paginaHTML = file_get_contents("templates/prodottoTemplate.html");

$error = "";
$contenuto = "";
$titolo = "";
$keywords = "";
$breadcrumb = "";
$titoloProdotto = "";
$immaginiProdotto = "";
$carrello = "";
$stringaMessaggio = "";
$aggiornamento1= "";
$aggiornamento2= "";

$listaprodotto = "";

$connection = new DBAccess();

if($connection->isLoggedInUser()){
    if ($connection->openDBConnection()){

        if(isset($_GET['id'])){
            $idProdotto = $_GET['id'];
            $listaprodotto = $connection->getProdottoById($idProdotto);
        
            if ($listaprodotto != null){

                foreach($listaprodotto as $prodotto){
                $contenuto = '<div id="product_Details"><h3>Specifiche Prodotto</h3>';

                $nomeCategoria = $connection->getCategoriaFromId($prodotto['categoria']);
                $connection->closeDBConnection();

                $categoriaLink = strtolower(str_replace(' ', '', $nomeCategoria[0]['nome']));
            
                $breadcrumb = '<a href="index.php"><span lang="en">Home</span></a> &gt; <a href="' . $categoriaLink . '.php"> ' . $nomeCategoria[0]['nome'] . ' </a> &gt;' . $prodotto['nome'];
            
                $titolo =  $prodotto['nome'];
            
                $keywords = $prodotto['keywords'];
            
                $titoloProdotto = $prodotto['nome'] ;
            
                $immaginiProdotto =    '<div id="product_Images">
                                    <img src="../' . $prodotto['immagine1'] . '" class="immagine_prodotto" alt="">
                                    <img src="../' . $prodotto['immagine2'] . '" class="immagine_prodotto" alt="">
                                    <img src="../' . $prodotto['immagine3'] . '" class="immagine_prodotto" alt="">
                                    <img src="../' . $prodotto['immagine4'] . '" class="immagine_prodotto" alt=""></div>';

                $contenuto .= '<ul id="product_Specs">
                                    <li><span class="specs_List">Prezzo:</span> '      . $prodotto['prezzo']       . '€</li>
                                    <li><span class="specs_List">Peso:</span> '         . $prodotto['peso']         . '</li> 
                                    <li><span class="specs_List">Dimensioni:</span> '   . $prodotto['dimensione']   . '</li>';
                
                if($prodotto['colore'] != NULL){
                    $contenuto .= '<li><span class="specs_List">Colore:</span> '       . $prodotto['colore']       . '</li>';
                }else{
                    $contenuto .= '<li><span class="specs_List">Colore:</span> Non disponibile';
                }

                if($prodotto['volume'] != NULL){
                    $contenuto .= '<li><span class="specs_List">Volume:</span> '       . $prodotto['volume']       . '</li>';
                }else{
                    $contenuto .= '<li><span class="specs_List">Volume:</span> Non disponibile';
                }

                if($prodotto['materialeUtilizzato'] != NULL){
                    $contenuto .= '<li><span class="specs_List">Materiali:</span> '    . $prodotto['materialeUtilizzato'] . '</li>';
                }else{
                    $contenuto .= '<li><span class="specs_List">Materiali:</span> Non disponibile';
                }

                $contenuto .= '<li><span class="specs_List">Categoria:</span> '    . $nomeCategoria[0]['nome'] . '</li></ul>{carrello}';
            

                $qnt = $prodotto['quantita'];
                    if($qnt != 0){
                        $carrello = '<form action="prodotto.php" class="form" id="form" method="get"><div id="cart_Specs">
                        <p class="cart_List">Seleziona quantità:</p><select name="opzione_selezionata" id="quantity"> ';
                        for ($i = 1; $i <= $qnt; $i++) {
                            $carrello .= '<option value="' . $i . '"> ' . $i . '</option>';
                        }
                        $carrello .= ' </select></div><input type="hidden" name="id" value="'.$prodotto['ID'].'"></input>
                        <input type="submit" name="addToCart" class="button" value="Aggiungi al carrello"></form>';
                    }elseif($qnt == 0){
                        $carrello .= '<p> Prodotto esaurito! Ci dispiace per il disagio, presto tornerà disponibile!</p>';
                    }
                     
                    $contenuto .= '<div id="product_Description"><h3>Descrizione</h3><p>' . $prodotto['descrizione'] . '</p></div>';
                
                $contenuto .= '<div id="delivery_Details"><h3>Dettagli di Consegna</h3><ul id="delivery_List">
                <li>Consegna in 3-5 giorni lavorativi.</li>
                <li>Spedizione gratuita per ordini superiori a 50 €.</li>
                </ul></div> ';
                }
                $contenuto .= '</div>';
               
                if(isset($_GET['addToCart'])){ // aggiungi al carrello
                    if ($connection->openDBConnection()){
                
                    $quantita_selezionata = $_GET['opzione_selezionata'];
                    $utente_sessione = $_SESSION['user'];
                    $idProdotto = $_GET['id'];
                    
                    $aggiornamento1 = $connection->saveToCart($utente_sessione,$idProdotto,$quantita_selezionata);

                    if($aggiornamento1 == 1){// aggiunto al carrello
                        $aggiornamento2 = $connection->updateProductQuantity($idProdotto,$quantita_selezionata);

                        if($aggiornamento2 == 0){// errato update quantità
                            $query = "";
                            $query = "DELETE FROM carrello WHERE IDprodotto=$idProdotto;";
                            $checkQuery=$connection->modifyDatabase($query);
    
                            if($checkQuery){
                                $stringaMessaggio = '<p class="error_Message" role="alert">Errore nell\'inserimento nel carrello.</p>';
                            }
                        }else{ //corretto update quantità
                            $stringaMessaggio = '<p class="success_Message" role="alert">Prodotto aggiunto al carrello.</p>';

                            $qnt =  $qnt - $quantita_selezionata;
                            if($qnt != 0){
                                $carrello = '<form action="prodotto.php" class="form" method="get"><div id="cart_Specs">
                                <p class="cart_List">Seleziona quantità:</p><select name="opzione_selezionata" id="quantity"> ';
                                for($i = 1; $i <= $qnt; $i++){
                                    $carrello .= '<option value="' . $i . '"> ' . $i . '</option>';
                                }
                                $carrello .= ' </select></div><input type="hidden" name="id" value="'.$prodotto['ID'].'"></input>
                                <input type="submit" name="addToCart" class="button" value="Aggiungi al carrello"></form>';
                            }elseif($qnt == 0){
                                $carrello = '<p> Prodotto esaurito! Ci dispiace per il disagio, presto tornerà disponibile!</p>';
                            }
                        }
                    }else{// non aggiunto al carrello
                        $stringaMessaggio = '<p class="error_Message" role="alert">Errore nell\'inserimento nel carrello.</p>';
                    }
                    $connection->closeDBConnection();
                    $paginaHTML = str_replace("{errori}",$stringaMessaggio,$paginaHTML);

                    }else{
                        $error = DBConnectionError(true);
                    }
                }
        
            }else{ // Prodotto non trovato
                $titolo = 'Prodotto Non Trovato';
                $breadcrumb = '<a href="index.php"><span lang="en">Home</span></a> &gt; Errore prodotto non trovato';
                $titoloProdotto = 'Prodotto non trovato';
                $error = '<p>Il prodotto selezionato non è più presente nei nostri magazzini.</p>';
            }
            $contenuto .= '</div>';

        }else{ // ID non valido, ID non presente nel database
            $error = '<p>Nessun prodotto che abbiamo attualmente nei nostri magazzini corrisponde a quello selezionato.</p>';
        }

        $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
        $paginaHTML = str_replace("{titolo}", $titolo, $paginaHTML);
        $paginaHTML = str_replace("{keywords}", $keywords, $paginaHTML);
        $paginaHTML = str_replace("{breadcrumb}", $breadcrumb, $paginaHTML);
        $paginaHTML = str_replace("{titoloProdotto}", $titoloProdotto, $paginaHTML); 
        $paginaHTML = str_replace("{immaginiProdotto}", $immaginiProdotto, $paginaHTML);
        $paginaHTML = str_replace("{contenutoProdotto}", $contenuto, $paginaHTML);
        $paginaHTML = str_replace("{carrello}", $carrello, $paginaHTML);

    }else{
        $error = DBConnectionError(true);
        $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
        $paginaHTML = str_replace("{titolo}", $titolo, $paginaHTML);
        $paginaHTML = str_replace("{keywords}", $keywords, $paginaHTML);
        $paginaHTML = str_replace("{breadcrumb}", $breadcrumb, $paginaHTML);
        $paginaHTML = str_replace("{titoloProdotto}", $titoloProdotto, $paginaHTML);
        $paginaHTML = str_replace("{immaginiProdotto}", $immaginiProdotto, $paginaHTML);
        $paginaHTML = str_replace("{contenutoProdotto}", $contenuto, $paginaHTML);
        $paginaHTML = str_replace("{carrello}", $carrello, $paginaHTML);
    }
}else{
    //ridirezionamento fuori areaUtente
    header("Location: ../index.php");
    die();
}

echo $paginaHTML;

?>

