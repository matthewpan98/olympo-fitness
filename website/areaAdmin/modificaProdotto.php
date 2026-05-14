<?php
    require_once "../connection.php";
    require_once "../funzioni.php";
    use DB\DBAccess;

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/modificaProdottoTemplate.html");
    $error = "";
    $listaCategoria = "";
    $stringaCategoria = "";
    $listaMarca = "";
    $stringaMarca= "";
    $stringaErrori = "";
    $stringaQuery = "";
    
    $nuova_categoria = "";
    $nuovo_prezzo = "";
    $nuovo_peso ="";
    $nuova_dimensione = "";
    $nuovo_colore = "";
    $nuovo_volume ="";
    $nuovo_materiale_utilizzato = "";
    $nuova_quantita = "";
    $nuova_descrizione = "";
    $nuove_keywords = "";
    $nuova_marca = "";
    $nuovo_alt = "";
    $ID = "";
    
    $err = [];

    $connection = new DBAccess();
    if($connection->isLoggedInAdmin()){
        if($connection->openDBConnection()){

            $result = $connection->getProductsFromDatabase();
            $connection->closeDBconnection();

            $prodotto_da_modificare = NULL;

            $scelta = "";
            $modifica = "";
            if($result != null) {
                foreach($result as $prodotto){
                    $scelta .= '<option value=' .$prodotto['ID']. '>' . $prodotto['nome'] . '</option>';
                }
            }else{
                $scelta = '<option value="0" disabled>Non ci sono prodotti</option>';
            }

        }else{
            $error = DBConnectionError(true);
            $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
            $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
        }

        if(isset($_POST["conferma_modifica"])){
            if($result != null){
                $id_prodotto_modifica = $_POST["lista_prodotti_modifica"];

                if($connection->openDBConnection()){

                    $prodotto_da_modificare = $connection->getProdottoById($id_prodotto_modifica);
                    $listaCategoria = $connection->getCategoriesFromDatabase();
                    $listaMarca = $connection->getMarcaFromDatabase();

                    $connection->closeDBconnection();

                    if($prodotto_da_modificare != null) {
                        if ($listaCategoria != null) {
                            foreach ($listaCategoria as $cate) {
                                $stringaCategoria .= '<option value="'.$cate['ID'].'">'.$cate['nome'].'</option>';
                            }
                        } else {
                            $stringaCategoria = '<option value="0" disabled>Non sono presenti categorie</option>';
                        }
            
                        if ($listaMarca != null) {
                            foreach ($listaMarca as $mar) {
                                $stringaMarca .= '<option value="'.$mar['ID'].'">'.$mar['nome'].'</option>';
                            }
                        } else {
                            $stringaMarca = '<option value="0" disabled>Non sono presenti marche</option>';
                        }

                        foreach($prodotto_da_modificare as $prod){

                        $scelta = '<option value=' .$prod['ID']. '>' . $prod['nome'] . '</option>';

                        $modifica = '<form action="modificaProdotto.php" class="form" method="post" onsubmit="validateFormProdotto()">
                        <h3> Modifica - ' . $prod['nome'] . '</h3>
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="' . $prod['nome'] . '" required>

                        <!--
                        <label for="immagine1_mod">Immagine in Alto a Sinistra:</label>
                        <input type="file" id="immagine1_mod" name="immagine1_mod" accept="image/*">
                        <img src="../' . $prod['immagine1'] . '" alt="" required>
                        
                        <label for="immagine2_mod">Immagine in Alto a Destra:</label>
                        <input type="file" id="immagine2_mod" name="immagine2_mod" accept="image/*">
                        <img src="../' . $prod['immagine2'] . '" alt="" required>
                        
                        <label for="immagine3_mod">Immagine in Basso a Sinistra:</label>
                        <input type="file" id="immagine3_mod" name="immagine3_mod" accept="image/*">
                        <img src="../' . $prod['immagine3'] . '" alt="" required>
                        
                        <label for="immagine4_mod">Immagine in Basso a Destra:</label>
                        <input type="file" id="immagine4_mod" name="immagine4_mod" accept="image/*">
                        <img src="../' . $prod['immagine4'] . '" alt="" required> -->
                        
                        <label for="categoria">Categoria:</label>
                        <select id="categoria" name="categoria" required>
                        {selezioneCategoria}
                        </select>

                        <label for="prezzo">Prezzo:</label>
                        <input type="text" id="prezzo" name="prezzo" value="' . $prod['prezzo'] . '" required>

                        <label for="peso">Peso:</label>
                        <input type="text" id="peso" name="peso" value="' . $prod['peso'] . '" required>

                        <label for="dimensione">Dimensione:</label>
                        <input type="text" id="dimensione" name="dimensione" value="' . $prod['dimensione'] . '" required>
                                
                        <label for="colore">Colore:</label>
                        <input type="text" id="colore" name="colore" value="' . $prod['colore'] . '">
                                
                        <label for="volume">Volume:</label>
                        <input type="text" id="volume" name="volume" value="' . $prod['volume'] . '">

                        <label for="materialeUtilizzato">Materiale Utilizzato:</label>
                        <input type="text" id="materialeUtilizzato" name="materialeUtilizzato" value="' . $prod['materialeUtilizzato'] . '">
                           
                        <label for="quantita">Quantità:</label>
                        <input type="text" id="quantita" name="quantita" value="' . $prod['quantita'] . '" required>       
                                
                        <label for="descrizione">Descrizione:</label>
                        <textarea id="descrizione" name="descrizione" cols="30" rows="5" required>' . $prod['descrizione'] . '</textarea>
                        
                        <label for="keywords"><span lang="en">Keywords</span>:</label>
                        <textarea id="keywords" name="keywords" cols="30" rows="5">' . $prod['keywords'] . '</textarea>
                
                        <label for="alt">Breve Descrizione di Supporto:</label>
                        <textarea id="alt" name="alt"  cols="30" rows="5" required>'. $prod['alt'].'</textarea>
                        
                        <label for="marca">Marca:</label>
                        <select id="marca" name="marca" required>        
                        {selezioneMarca}
                        </select><input type="hidden" name="IDp" value="'. $prod['ID'].'">
                        <input type="submit" name="submit_modifica" class="button" value="Salva Modifiche"></form>';
                        }
                        
                        
                    }else{
                        $error = '<p class="error_Message" role="alert">Errore di caricamento del prodotto</p>'; 
                        $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                        $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
                    }

                }else{
                    $error = DBConnectionError(true);
                    $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                    $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
                }
            }else{
                $error = '<p class="error_Message" role="alert">Non ci sono attualmente prodotti nel nostro sistema</p>';
                $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
                $paginaHTML = str_replace("{modifica}", $error, $paginaHTML);
            }
            
        }
          
        
        if(isset($_POST["submit_modifica"])){ 
            
            $ID = $_POST['IDp'];
            $nuovo_nome = sanitizeInput($_POST['nome']);

            $nuova_categoria = sanitizeInput($_POST['categoria']);
            $nuovo_prezzo = sanitizeInput($_POST['prezzo']);
            $nuovo_peso = sanitizeInput($_POST['peso']);
            $nuova_dimensione = sanitizeInput($_POST['dimensione']);
            $nuovo_colore = sanitizeInput($_POST['colore']);
            $nuovo_volume = sanitizeInput($_POST['volume']);
            $nuovo_materiale_utilizzato = sanitizeInput($_POST['materialeUtilizzato']);
            $nuova_quantita = sanitizeInput($_POST['quantita']);
            $nuova_descrizione = sanitizeInput($_POST['descrizione']);
            $nuove_keywords = sanitizeInput($_POST['keywords']);
            $nuova_marca = sanitizeInput($_POST['marca']);
            $nuovo_alt = sanitizeInput($_POST['alt']);


            if(!preg_match('/\w{3,}/',$nuovo_nome)){ 
                array_push($err,'<p class="error_Message" role="alert">Nome del prodotto deve essere maggiore di 3 lettere.</p>');
            }
            
            if($nuova_categoria < 0){ 
                array_push($err,'<p class="error_Message" role="alert">Non sono presenti categorie nel nostro sistema.</p>');
            }
            if($nuovo_prezzo < 0){ 
                array_push($err,'<p class="error_Message" role="alert">Non si possono inserire prodotti con prezzo minore o uguale a zero.</p>');
            }
            if(!preg_match('/\w{2,}/',$nuovo_peso)){ 
                array_push($err,'<p class="error_Message" role="alert">Peso inserito non corretto.</p>');
            }
            if(!preg_match('/\w{2,}/',$nuova_dimensione)){ 
                array_push($err,'<p class="error_Message" role="alert">Dimensione inserita non corretta.</p>');
            }
            if($nuova_quantita < 0){ 
                array_push($err,'<p class="error_Message" role="alert">Quantità non può essere minore o uguale a zero.</p>');
            }
            if(strlen($nuova_descrizione)<25){
                array_push($err,'<p class="error_Message" role="alert">Descrizione deve essere superiore a 25 caratteri.</p>');
            }
            if($nuova_marca < 0){ 
                array_push($err,'<p class="error_Message" role="alert">Non sono presenti marche nel nostro sistema.</p>');
            }
            if(strlen($nuovo_alt)<5 && strlen($nuovo_alt)>75){ 
                array_push($err,'<p class="error_Message" role="alert">Breve descrizione di supporto deve essere almeno di 5 caratteri e non superiore a 75 caratteri.</p>');
            }
        
            if(count($err)==0){
                if($connection->openDBConnection()){
                $query = "";
                $query = "UPDATE prodotto SET 
                        nome='$nuovo_nome', 
                        categoria=$nuova_categoria, 
                        keywords='$nuove_keywords', 
                        prezzo=$nuovo_prezzo, 
                        peso='$nuovo_peso', 
                        dimensione='$nuova_dimensione', 
                        colore='$nuovo_colore', 
                        volume='$nuovo_volume', 
                        materialeUtilizzato='$nuovo_materiale_utilizzato', 
                        quantita=$nuova_quantita,
                        descrizione='$nuova_descrizione', 
                        marca=$nuova_marca, 
                        alt='$nuovo_alt' 
                        WHERE ID=$ID";


                $checkQuery = $connection->modifyDatabase($query);
                $connection->closeDBconnection();
                if($checkQuery){
                    $stringaQuery = '<p class="success_Message" role="alert">Modifica del prodotto avvenuta con successo</p>';

                }else{
                    $stringaQuery = '<p class="error_Message" role="alert">Errore durante la modifica del prodotto</p>';
                }
            }else{
                $stringaErrori = DBConnectionError(true);
            } 
        }else{
            //Mostra form con errori di formato
            $stringaErrori = '<ul>';
            foreach($err as $ers){
                $stringaErrori .= '<li>'.$ers.'</li>';
            }
            $stringaErrori .= '</ul>';

            $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
            $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);
            $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
            $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML); 
            $paginaHTML = str_replace("{risultatoQuery}",$stringaErrori,$paginaHTML);  
        }
        }// non hai cliccato la seconda
        $paginaHTML = str_replace("{scegliProdotto}", $scelta, $paginaHTML);
        $paginaHTML = str_replace("{modifica}", $modifica, $paginaHTML);
        $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
        $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML); 
        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML); 
    }else{
        //ridirezionamento fuori areaAdmin
       header("Location: ../index.php");
       die();
    }
    
    echo $paginaHTML;

?>