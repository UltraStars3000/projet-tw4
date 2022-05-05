<?php
$nom = $_POST['nom'];
$note = $_POST['note'];

include "connexion.php";

$req = $bdd->prepare('UPDATE lieux SET nbVotes = (nbVotes + 1) WHERE nom = :nom_lieux');

$req->execute(array(
       'nom_lieux' => $nom
       ));


$req2 = $bdd->prepare('UPDATE lieux SET note = (note + :n) WHERE nom = :nom_lieux');

$req2->execute(array(
              'nom_lieux' => $nom,
              'n' => $note
              ));

if ($res == false){
    echo "\nPDOStatement::errorInfo():\n";
    $arr = $req->errorInfo();
    print_r($arr);
    
}


?>