<?php

/*

    QUESTO SCRIPT ESEGUE UNA QUERY PER INSERIRE NEL DATABASE UN URL ABBREVIATO
*/
header('Access-Control-Allow-Origin: *');

require_once 'vendor/autoload.php'; //include mongodb la classe
require 'JWT_ENCODE_DECODE.php';
require 'MONGO_MANAGER.php';
require 'SHORTER.php';

$manager = new MongoManager();
$manager->getConnection('localhost', '27017');

$secret_key = "ThisIsTheSecretKey12ForJWT"; //key per decodificare/codificare il token JWT

$shortener = new Shorter();
$tokenmanager = new JwtAuth;

$postdata = file_get_contents("php://input"); //prende in get il json dall'app

if (isset($postdata)) { //se ci sono i requisiti nella get
    $request = json_decode($postdata, true); //decode della get
    $token = $request['token']; //prende il token passato dalla app
    $id_user = $tokenmanager->get_id_user($token); //prende dall'array decodificato l'id dell'use (da creare come hash sequenziale per avere il tutto sicuro)
    $url = $request['url_full']; //prende dal json dell'app l'url iniziale
    $name = $request['name'];    //prende il nome assegnato all'url iniziale
    $short_code = $shortener->short("localhost","27017"); //genera un hash nuovo e univoco
    $short_url = "http://musho.ga/?q=" . $short_code; //genera un url corta composta dal dominio e dal nuovo hash
    //inserire controllo sulla validità dell'url. Basta una request http
    if ($url != "") { //se l'url ottenuta non è vuota
        $result = $manager->addDocument('musho.url', ['id' => $short_code, 'name' => $name, 'id_user' => $id_user, 'url_full' => $url, 'url_short' => $short_url]);  //esegue query per inserire in db
    } else {
        echo "Empty url"; //return errore
    }
} else {
    echo "Error getting postdata"; //errore per dati inviati
}
?>