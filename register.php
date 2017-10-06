<?php
header('Access-Control-Allow-Origin: *');
require 'MONGO_MANAGER.php';

$client = new MongoClient();
$db = $client->musho;
$collection = $db->user;

$manager = new MongoManager();
$manager->getConnection("localhost","27012");


$postdata = file_get_contents("php://input");

if (isset($postdata)) {

    $request = json_decode($postdata, true);

    $username = $request["username"];
    $email = $request["email"];
    $password = $request["password"];

    //crypt password
    $password = crypt($password, '$2a$09$trythissecretkeyifyouwanttogetthepassword$');
    $params = array("username" => $username, "email" => $email, "password" => $password);


    $filter_user=['username'=>$username];
    $filter_email=['email'=>$email];

    $result_get_user= $manager->getDocument("musho.user",$filter_user);
    $result_get_email = $manager->getDocument("musho.user",$filter_email);
    if(empty($result_get_email)&&empty($result_get_user)){
        $manager->addDocument("musho.user",$params);
    }
    else {
        return "errore utente già presente";
    }
}

?>