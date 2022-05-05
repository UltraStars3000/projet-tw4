<?php
session_start();
include "connexion.php";

$pseudo = $_POST['pseudo'];
$pass = $_POST['password'];


if(isset($_POST['submit'])){

    $sql = "SELECT * FROM membres WHERE pseudo = '$pseudo'";
    $result = $bdd->prepare($sql);
    $result->execute();

    //echo $result->rowcount();

    if($result->rowcount() > 0){
        $data = $result->fetchAll();
        if(password_verify($pass,$data[0]["mdp"])){
            $_SESSION['id'] = $data[0]["id_membre"];
            $_SESSION['pseudo'] = $data[0]["pseudo"];
            $_SESSION['mdp'] = "true";
            header('Location: ../map/index.php');
            exit();
        }
        else{
            $_SESSION['mdp'] = "false";
            header('Location: logine.php');
        }
    }
    else{
        echo "Pas d'utilisateur enregistré";
    }
    
}
