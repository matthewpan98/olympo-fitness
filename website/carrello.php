<?php
    setlocale(LC_ALL, 'it_IT');
    
    $paginaHTML = file_get_contents('templates/carrelloTemplate.html');

    $stringaMessaggio = "";

    $stringaMessaggio = '<p class="error_Message" role="alert">Questa pagina non è ancora disponibile perchè non sei collegato con nessun <span lang="en">account</span>. Ti preghiamo di effettuare il <span lang="en">login</span> presente nella pagina <span lang="en">account</span>.</p>';

    $paginaHTML = str_replace("{errori}",$stringaMessaggio,$paginaHTML);

    echo $paginaHTML;

?>