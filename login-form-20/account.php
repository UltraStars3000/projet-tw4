<?php
session_start();
include "connexion.php";

$pseudo = $_POST['pseudo'];
$pass = $_POST['password'];


if(isset($_POST['submit'])){
    
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO membres (pseudo,mdp) VALUES ('$pseudo','$pass')";
    $req = $bdd->prepare($sql);
    $req->execute();

    if(isset($_SESSION['mdp'])){
        unset($_SESSION['mdp']);
    }

    header('Location: ../map/index.php');
    exit();

    
   

  
    
}
