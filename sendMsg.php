<?php
$sender = $_POST['sender'];
$receiver = $_POST['receiver'];
$msg = $_POST['msg'];



include "connexion.php";

$reponse =  $bdd->query("INSERT INTO messages (id_sender, id_receiver, message) 
                        VALUES ('$sender', '$receiver', '$msg') 
                        ");

if ($res == false){
    echo "\nPDOStatement::errorInfo():\n";
    $arr = $req->errorInfo();
    print_r($arr);
    
}


?>