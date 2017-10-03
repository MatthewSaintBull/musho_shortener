<?php
header('Access-Control-Allow-Origin: *');

$client = new MongoClient();
$db = $client->musho;
$collection = $db->user;
$postdata = file_get_contents("php://input");
if (isset($postdata)) {

    $request = json_decode($postdata, true);
    var_dump($request);
    $username = $request["username"];
    $email = $request["email"];
    $password = $request["password"];

    //crypt password
    $password = crypt($password, '$2a$09$trythissecretkeyifyouwanttogetthepassword$');
    $query = array("username" => $username, "email" => $email, "password" => $password);

    $result = $collection->find(array('username' => $username));
    if (count($result) == 0) {
        $collection->insert($query);
    } else {
        return "errore utente già presente";
    }
}

?>