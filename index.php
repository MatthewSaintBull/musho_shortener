<?php


$item = $_GET["q"];
require_once 'vendor/autoload.php'; //INCLUDE CLASSE MONGODB


$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017"); //INIZIALIZZA CONNESSIONE MONGODB
$filter = array('id' => $item);
$query = new MongoDB\Driver\Query($filter);  //definisce la query col filtro
$result = $manager->executeQuery("musho.url", $query); //esegue la query sulla collection user del db musho
$url = current($result->toArray()); //risultato della query castato in array
if (!empty($url)) { //se non è vuoto
    $address = $url->url_full;
    header("Location: $address");
    exit();
} else echo "indirizzo inesistente";
?>
