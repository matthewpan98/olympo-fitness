<?php

use DB\DBAccess;

require_once('connection.php');

    function sanitizeInput($input) {
        
        $input = strip_tags($input);
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8'); 
        $input = stripslashes($input);
        $input = preg_replace('/\s+/', ' ', $input);
        $input = trim($input); 

        return $input;
    }

    function DBConnectionError(bool $uscita = false){
        return '<p class="errorDB" role="alert">I sistemi sono momentaneamente fuori servizio. Ci scusiamo per il disagio.
        Torna alla <a href="'.($uscita?'../':'').'index.php"><span lang="en">Home</span></a> o riprova più tardi.</p>'; 
    }


?>