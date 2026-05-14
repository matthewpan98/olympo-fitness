<?php
require_once "connection.php";

use DB\DBAccess;

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("templates/indexTemplate.html");
$stringaCategorie = "";
$listaCategorie = "";
$listaBrands = "";
$stringaBrands = "";
$nomeLinkMinuscolo = "";
$nomeCategorieMinuscolo = "";

$connection = new DBAccess();

    if($connection->openDBConnection()) {
    
        $listaCategorie = $connection->getCategoriesFromDatabase();
        $listaBrands = $connection->getBrandsFromDatabase();
        
        $connection->closeDBConnection();
        $stringaCategorie = '<ul id="categories_Container">';

        if ($listaCategorie != null) {

            foreach ($listaCategorie as $categoria) {
                $nomeCategorieMinuscolo = strtolower(str_replace(' ', '', $categoria["nome"]));
                $stringaCategorie .= '<li><a href="' . $nomeCategorieMinuscolo . '.php"><img src="' . $categoria["immagineSfondo"] . '" alt="">' . $categoria["nome"] . '</a></li>';
                $nomeCategorieMinuscolo = "";
            }

        } else {
            $stringaCategorie .= "<li>Non sono presenti categorie</li>";
        }
        $stringaCategorie .= '</ul>';
        
        $stringaBrands ='<ul id="brand_Container">';
        if ($listaBrands != null) {

            foreach ($listaBrands as $brands) {
                $nomeLinkMinuscolo = strtolower(str_replace(' ', '', $brands["nome"]));
                $stringaBrands .= '<li><a href="https://www.' . $nomeLinkMinuscolo . '.com/"><img src="' . $brands["immagineSfondo"] . '" alt="' . $brands["nome"] . '"></a></li>';
                $nomeLinkMinuscolo = "";
            }
        } else {
            $stringaBrands .= "<li>Non sono presenti brand</li>";
        }

        $stringaBrands .='</ul>';
        
    } else {
        $stringaCategorie .= DBConnectionError(true);
    }

$paginaHTML = str_replace("{categorie}", $stringaCategorie, $paginaHTML);
$paginaHTML = str_replace("{brands}", $stringaBrands, $paginaHTML);
echo $paginaHTML;

?>