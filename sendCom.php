<?php
$nom = $_POST['nom'];
$commentaire = $_POST['commentaire'];
$pseudo = $_POST['pseudo'];

include "connexion.php";


$stmt = $bdd->prepare("INSERT INTO commentaires (nom_lieux, commentaire, pseudo) VALUES (:nom, :com, :ps)");
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':com', $commentaire);
$stmt->bindParam(':ps', $pseudo);

$stmt->execute();


if ($res == false){
    echo "\nPDOStatement::errorInfo():\n";
    $arr = $req->errorInfo();
    print_r($arr);
    
}


?>