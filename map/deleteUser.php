<?php
$id = $_POST['id'];



include "connexion.php";

$req = $bdd->prepare('DELETE FROM utilisateurs WHERE utilisateurs.id_utilisateurs = :id');
$res = $req->execute(array('id' => $id));

if ($res == false){
    echo "\nPDOStatement::errorInfo():\n";
    $arr = $req->errorInfo();
    print_r($arr);
    
}


?>