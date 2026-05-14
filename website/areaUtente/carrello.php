<?php
    require_once "../connection.php";
    require_once "../funzioni.php";

    use DB\DBAccess;
    session_start();
    $connection = new DBAccess();

    setlocale(LC_ALL, 'it_IT');
    
    $paginaHTML = file_get_contents('templates/carrelloTemplate.html');

    $stringaRiepilogo = "";
    $stringaMessaggio = "";
    $error = "";
    $listaProdotti = "";
    $stringaProdotti = "";
    $stringaPagamento = "";

    $arrayRemove = array();

    $errorForm = [];
    
    $prezzoParziale = 0;
    $prezzoSpedizione = 0; //se prezzoParziale >50 questa variabile resta 0; altrimenti diventa 7
    $prezzoTotale = 0;
    $numeroProdotti = 0;


    if($connection->isLoggedInUser()){
        
        if($connection->openDBConnection()){
            $risultato=array();
            
            $id = $_SESSION['user'];

            $risultato = $connection->getRiepilogoFromDatabase($id);
            $listaProdotti = $connection->getProdottiCarrello($id);


            $connection->closeDBConnection();

            $stringaPagamento ='
            <input type="submit" name="shopButton" class="button" value="Acquista ora">
            <div id="delivery_Address">
            <h3>Indirizzo di consegna:</h3>
  
            <label for="address">Indirizzo:</label>
            <input type="text" name="address" id="address" placeholder="Via Rossi 53" required>
            
            <label for="city">Città:</label>
            <input type="text" name="city" id="city" placeholder="Vicenza" required>
            
            <label for="cap"><abbr title="Codice Avviamento Postale">CAP</abbr>:</label>
            <input type="text" name="cap" id="cap" placeholder="36100" required>
  
            </div>
            <div id="delivery_Payments">
            <h3>Modalità di pagamento:</h3>
  
            <label for="payment_method">Scegli un metodo di pagamento:</label>
            <select id="payment-method" name="payment_method" required>
              <option value="credit_card">Carta di credito/debito</option>
              <option value="paypal"><span lang="en">PayPal</span></option>
              <option value="google_pay"><span lang="en">Google Pay</span></option>
            </select>
  
            </div>';
            
            if($listaProdotti != null && $risultato != null) {

                $prezzoParziale = (array_values($risultato[0])[0]);
                $numeroProdotti = (array_values($risultato[1])[0]);

                $prezzoParziale>50 ? $prezzoSpedizione=0 : $prezzoSpedizione=7;

                $prezzoTotale = $prezzoParziale + $prezzoSpedizione;

                $stringaRiepilogo = '<dd>Prezzo parziale: ' .$prezzoParziale.'€</dd><dd>Costo spedizione: ' .$prezzoSpedizione.'€</dd> <dd>Totale: ' .$prezzoTotale.' € ( ' .$numeroProdotti.' articoli selezionati)</dd>';
                foreach ($listaProdotti as $prodotti) {
                    
                    $stringaProdotti .= '<li><a href="prodotto.php?id=' . $prodotti["IDprodotto"] . '"><img src="../' . $prodotti["immagine1"] . '" alt="' . $prodotti["alt"] . '"><div class="product_Info"><p>' . $prodotti["nome"] . ' € ' . $prodotti["prezzo"] . '</p>
                    <p>Quantità: ' . $prodotti["quantita"] . '</p></a>
                    <form action="carrello.php" method="get">
                        <input type="hidden" name="id" value="' . $prodotti["IDprodotto"] . '">
                        <input type="submit" name="remove" class="button" value="Rimuovi Prodotto">
                    </form></div></li>';

                    $arrayRemove[$prodotti["IDprodotto"]] = $prodotti["quantita"];
                }
            }else{
                $stringaRiepilogo = "<dd>Prezzo Parziale: 0€</dd><dd>Costo spedizione: 0€</dd><dd>Totale: 0€ (0 articoli selezionati)</dd> ";
                $stringaProdotti = "<p>Non sono presenti prodotti nel tuo carrello.</p>";
            }



            if(isset($_GET['remove'])){

                $idRimozione = $_GET['id'];

                if($connection->openDBConnection()){

                $query1 = "UPDATE prodotto SET quantita = quantita +  $arrayRemove[$idRimozione] WHERE ID = $idRimozione;";
                $query2 = "DELETE FROM carrello WHERE IDutente = $id AND IDprodotto = $idRimozione;";

                $checkQuery1=$connection->modifyDatabase($query1);
                $checkQuery2=$connection->modifyDatabase($query2);
                if($checkQuery1 && $checkQuery2){
                    $error = '<p class="success_Message">Eliminazione prodotto dal carrello avvenuta con successo.</p>';

                $risultato=array();
                
                            $risultato = $connection->getRiepilogoFromDatabase($id);
                            $listaProdotti = $connection->getProdottiCarrello($id);
                
                            if($listaProdotti != null && $risultato != null) {

                                $prezzoParziale = (array_values($risultato[0])[0]);
                                $numeroProdotti = (array_values($risultato[1])[0]);
                
                                $prezzoParziale>50 ? $prezzoSpedizione=0 : $prezzoSpedizione=7;
                
                                $prezzoTotale = $prezzoParziale + $prezzoSpedizione;
                
                                $stringaRiepilogo = '<dd>Prezzo parziale: ' .$prezzoParziale.'€</dd><dd>Costo spedizione: ' .$prezzoSpedizione.'€</dd> <dd>Totale: ' .$prezzoTotale.' € ( ' .$numeroProdotti.' articoli selezionati)</dd>';
                                $stringaProdotti = "";
                                foreach ($listaProdotti as $prodotti) {
                                    
                                    $stringaProdotti .= '<li><a href="prodotto.php?id=' . $prodotti["IDprodotto"] . '"><img src="../' . $prodotti["immagine1"] . '" alt="' . $prodotti["alt"] . '"><div class="product_Info"><p>' . $prodotti["nome"] . ' € ' . $prodotti["prezzo"] . '</p>
                                    <p>Quantità: ' . $prodotti["quantita"] . '</p></a>
                                    <form action="carrello.php" method="get">
                                        <input type="hidden" name="id" value="' . $prodotti["IDprodotto"] . '">
                                        <input type="submit" name="remove" class="button" value="Rimuovi Prodotto">
                                    </form></div></li>';
                
                                    $arrayRemove[$prodotti["IDprodotto"]] = $prodotti["quantita"];
                                }
                            }else{
                                $stringaRiepilogo = "<dd>Prezzo Parziale: 0€</dd><dd>Costo spedizione: 0€</dd><dd>Totale: 0€ (0 articoli selezionati)</dd> ";
                                $stringaProdotti = "<p>Non sono presenti prodotti nel tuo carrello.</p>";
                            }
                       
                    }else{
                    $error = '<p class="error_Message" role="alert">Errore nella rimozione dal carrello.</p>';
                    }
                             
                }else{
                    $error = DBConnectionError(true);
                }
            }





            if(isset($_POST['shopButton'])){

                $indirizzo = sanitizeInput($_POST['address']);
                $citta = sanitizeInput($_POST['city']);
                $cap = sanitizeInput($_POST['cap']);
        
        
                if(!preg_match('/^[A-Za-z]+(\s[A-Za-z]+)*\s\d+$/',$indirizzo)){
                    array_push($errorForm,'<p class="error_Message" role="alert">Inserire un indirizzo valido.</p>');
                }
                if(!preg_match('/^[A-Za-z]+$/',$citta)){
                    array_push($errorForm,'<p class="error_Message" role="alert">Nome della città non corretto.</p>');
                }
        
                if(!preg_match('/^\d{5}$/',$cap)){
                    array_push($errorForm,'<p class="error_Message" role="alert">Formato del <abbr title="Codice Avviamento Postale">CAP</abbr> non corretto.</p>');
                }
                
                if(count($errorForm)==0){
                    if($listaProdotti != null){
                        if($connection->openDBConnection()){

                        $query = "DELETE FROM carrello WHERE IDutente=$id;";
                        $checkQuery=$connection->modifyDatabase($query);
                        $connection->closeDBConnection();

                            if($checkQuery){
                                $stringaRiepilogo = "<dd>Prezzo Parziale: 0€</dd><dd>Costo spedizione: 0€</dd><dd>Totale: 0€ (0 articoli selezionati)</dd> ";
                                $stringaProdotti = "<p>Non sono presenti prodotti nel tuo carrello.</p>";

                                $error = '<p class="success_Message" role="alert">Acquisto effettuato con successo.</p>';
   
                            }else{
                            $error = '<p class="error_Message" role="alert">Per fare un acquisto devi avere almeno un prodotto nel tuo carrello</p>' ;
                            }
                        }else{
                            $error = DBConnectionError(true);
                        }
                    }else{
                        $error = '<p class="error_Message" role="alert">Per fare un acquisto devi avere almeno un prodotto nel tuo carrello</p>' ;
                    }
                }else{
                    $error = '<ul>';
                        foreach($errorForm as $errorList){
                            $error .= '<li>'.$errorList.'</li>';
                        }
                    $error .= '</ul>';
                }
            }



            $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
            $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
            $paginaHTML = str_replace("{formCarrello}",$stringaPagamento,$paginaHTML);
            $paginaHTML = str_replace("{prodottiCarrello}",$stringaProdotti,$paginaHTML);

        }else{
            $error .= DBConnectionError(true);
            $paginaHTML = str_replace("{errori}",$error,$paginaHTML);
            $paginaHTML = str_replace("{riepilogoOrdine}",$stringaRiepilogo,$paginaHTML);
            $paginaHTML = str_replace("{formCarrello}",$stringaPagamento,$paginaHTML);
            $paginaHTML = str_replace("{prodottiCarrello}",$stringaProdotti,$paginaHTML);
        }
    }    
    else{ //ridirezionamento fuori areaUtente
        header("Location: ../index.php");
        die();
    }

    echo $paginaHTML;

?>