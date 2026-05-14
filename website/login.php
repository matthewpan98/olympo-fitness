<?php

    require_once "connection.php";
    require_once "funzioni.php";
    session_start();

    use DB\DBAccess;
    setlocale(LC_ALL, 'it_IT');

    $connection = new DBAccess();
    $paginaHTML     = file_get_contents('templates/loginTemplate.html');

    $stringaErrori = "";
    $stringaLogout = "";
    $DBerror = "";

        if(isset($_POST['submit'])){
            //Invio del form

            $errori = [];

            $nome = sanitizeInput($_POST['nome']);
            $password = sanitizeInput($_POST['password']);


            if(!preg_match('/\w{3,}/',$nome)){
                array_push($errori,'<p class="error_Message" role="alert">Formato del nome non corretto</p>');
            }

            if(strlen($password)<4){
                array_push($errori,'<p class="error_Message" role="alert">Formato della <span lang="en">password</span> non corretto.</p>');
            }

            if(count($errori)==0){

                if($connection->openDBconnection()){
                    
                    
                    $users = $connection->getRowsFromDatabase($nome);  
                    $connection->closeDBconnection();

                    if(count($users)>0){ //esistono persone
                       
                        $user = $users[0];
                        if($user['amministratore']==1)
                        {
                            if($password==$user['passw']){

                                $_SESSION['user'] = $user['id'];
    
                                header("Location: areaAdmin/GestioneProdotti.php"); 
                                die();
    
                            }else{ 
                                array_push($errori,'<p class="error_Message" role="alert">Nome o <span lang="en">password</span> non corretti</p>');
                            }
                        }
                        elseif($user['amministratore']==0)
                        {
                            if($password==$user['passw']){

                                $_SESSION['user'] = $user['id'];
    
                                header("Location: areaUtente/index.php");
                                die();
    
                            }else{ 
                                array_push($errori,'<p class="error_Message" role="alert">Nome o <span lang="en">password</span> non corretti</p>');
                            }
                        }

                    }else{//persona non trovata
                        array_push($errori,'<p class="error_Message" role="alert">Nome o <span lang="en">password</span> non corretti</p>');
                    }

                    $stringaErrori = '<ul>';
                    foreach($errori as $error){
                        $stringaErrori .= '<li>'.$error.'</li>';
                    }
                    $stringaErrori .= '</ul>';
                    $paginaHTML = str_replace("{erroriLogin}",$stringaErrori,$paginaHTML);
                    $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
                    
                }else{ //non è stato possibile aprire una connessione al database
                    $DBerror .= DBConnectionError(true);
                    $paginaHTML = str_replace("{erroriLogin}",$DBerror,$paginaHTML);
                    $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
                }                       
            }else{
                 //Mostra form con errori di formato
                $stringaErrori = '<ul>';
                foreach($errori as $error){
                    $stringaErrori .= '<li>'.$error.'</li>';
                }
                $stringaErrori .= '</ul>'; 
                $paginaHTML = str_replace("{erroriLogin}",$stringaErrori,$paginaHTML);
                $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
            }
        }else{ //non hai inviato ancora il form
            $paginaHTML = str_replace("{erroriLogin}",$stringaErrori,$paginaHTML);
            $paginaHTML = str_replace("{logout}",$stringaLogout,$paginaHTML);
        } 

    echo $paginaHTML;

?>
