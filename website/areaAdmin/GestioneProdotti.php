<?php
    require_once "../connection.php";
    require_once "../funzioni.php";

    use DB\DBAccess;

    setlocale(LC_ALL, 'it_IT');
    session_start();

    $paginaHTML = file_get_contents("templates/GestioneProdottiTemplate.html");

    $connection = new DBAccess();
    $stringaErrori = "";
    $stringaQuery = "";
    $err = [];
    
    $listaCategoria = "";
    $stringaCategoria = "";

    $listaMarca = "";
    $stringaMarca= "";

    $nome = "";
    $categoria = "";
    $keywords = "";
    $prezzo = "";
    $peso = "";
    $colore = "";
    $dimensione = "";
    $volume = "";
    $materialeUtilizzato = "";
    $quantita = "";
    $descrizione = "";
    $marca = "";
    $alt = "";

    if($connection->isLoggedInAdmin()){

        if($connection->openDBConnection()){

            $listaCategoria = $connection->getCategoriesFromDatabase();
            $listaMarca = $connection->getMarcaFromDatabase();

            $connection->closeDBConnection();
        
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

        }else{
            $stringaErrori = DBConnectionError(true);
        }

        if(isset($_POST["submit"])){
           
            $nome = sanitizeInput($_POST['nome']);
            
            $categoria = $_POST['categoria'];

            $keywords = sanitizeInput($_POST['keywords']);
            $prezzo = sanitizeInput($_POST['prezzo']);
            $peso = sanitizeInput($_POST['peso']);
            $dimensione = sanitizeInput($_POST['dimensione']);
            $colore = sanitizeInput($_POST['colore']);
            $volume = sanitizeInput($_POST['volume']);
            $materialeUtilizzato = sanitizeInput($_POST['materialeUtilizzato']);
            $quantita = sanitizeInput($_POST['quantita']);
            $descrizione = sanitizeInput($_POST['descrizione']);
            
            $marca = $_POST['marca'];

            $alt = sanitizeInput($_POST['alt']);
            
            
            if(!preg_match('/\w{3,}/',$nome)){ 
                array_push($err,'<p class="error_Message" role="alert">Nome del prodotto deve essere maggiore di 3 caratteri.</p>');
            }
            if($categoria < 0){
                array_push($err,'<p class="error_Message" role="alert">Non sono presenti categorie nel nostro sistema.</p>');
            }
            if(floatval($prezzo) < 0){ 
                array_push($err,'<p class="error_Message" role="alert">Non si possono inserire prodotti con prezzo minore o uguale a zero.</p>');
            }
            if(!preg_match('/\w{3,}/',$peso)){ 
                array_push($err,'<p class="error_Message" role="alert">Peso inserito non corretto.</p>');
            }
            if(!preg_match('/\w{2,}/',$dimensione)){ 
                array_push($err,'<p class="error_Message" role="alert">Dimensione inserita non corretta.</p>');
            }
            if(intval($quantita) < 0){
                array_push($err,'<p class="error_Message" role="alert">Quantità non può essere minore o uguale a zero.</p>');
            }
            if(strlen($descrizione)<25){ 
                array_push($err,'<p class="error_Message" role="alert">Descrizione deve essere superiore a 25 caratteri.</p>');
            }
            if($marca < 0){ 
                array_push($err,'<p class="error_Message" role="alert">Non sono presenti marche nel nostro sistema.</p>');
            }
            if(strlen($alt)<5 || strlen($alt)>75){ 
                array_push($err,'<p class="error_Message" role="alert">Breve descrizione di supporto deve essere almeno di 5 caratteri e non superiore a 75 caratteri.</p>');
            }
        
            if(count($err)==0){

            if($connection->openDBConnection()){

                $query = "";
                $query = "INSERT INTO prodotto(nome, categoria, keywords, prezzo, peso, dimensione, colore, volume, materialeUtilizzato, quantita, descrizione, marca, alt) VALUES ('$nome', '$categoria', '$keywords', '$prezzo', '$peso', '$dimensione', '$colore', '$volume', '$materialeUtilizzato', '$quantita', '$descrizione', '$marca', '$alt')";
    
                $checkQuery = $connection->modifyDatabase($query);
                $connection->closeDBconnection();

                    if($checkQuery) {
                        $stringaQuery = '<p class="succes_Message" role="alert">Il prodotto è stato correttamente aggiungo al <span lang="en">database</span>.</p>';
                    }else{
                        $stringaQuery = '<p class="error_Message" role="alert">Non è stato possibile aggiungere il prodotto al <span lang="en">database</span>, se l\'errore sussiste si rivolga all\'assistenza.</p>';
                    }
            }else{
                $stringaErrori = DBConnectionError(true);
                $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);  
                $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML); 
                $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
                $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML); 
            }

            }else{
            //Mostra form con errori di formato
            $stringaErrori = '<ul>';
                foreach($err as $ers){
                    $stringaErrori .= '<li>'.$ers.'</li>';
                }
            $stringaErrori .= '</ul>';

            $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);
            $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML);
            $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
            $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML);    
            }  

        } // non hai premuto, replace finali
        $paginaHTML = str_replace("{errori}",$stringaErrori,$paginaHTML);  
        $paginaHTML = str_replace("{risultatoQuery}",$stringaQuery,$paginaHTML); 
        $paginaHTML = str_replace("{selezioneCategoria}",$stringaCategoria,$paginaHTML);
        $paginaHTML = str_replace("{selezioneMarca}",$stringaMarca,$paginaHTML);     

    }else{
        //ridirezionamento fuori areaAdmin
        header("Location: ../index.php");
        die();
    }

    echo $paginaHTML;
?>