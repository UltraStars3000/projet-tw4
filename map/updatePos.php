<?php
$id = $_POST['id'];
$pseudo = $_POST['pseudo'];
$long = $_POST['long'];
$lat = $_POST['lat'];


include "connexion.php";

$reponse =  $bdd->query("INSERT INTO utilisateurs (id_utilisateurs, pseudo, latitude, longitude) 
                        VALUES ('$id', '$pseudo', '$lat', '$long') 
                        ON DUPLICATE KEY UPDATE latitude = '$lat', longitude = '$long' 
                        ");

if ($reponse == false){
    echo "\nPDOStatement::errorInfo():\n";
    
}


?>