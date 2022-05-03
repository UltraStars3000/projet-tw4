<?php
session_start();

$pseudo = $_POST['pseudo']; // récupère les entrées du formulaire
$pass = $_POST['pass'];

if(isset($pseudo, $pass)) {
    include "connexion.php";
    
    // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
    // pour éliminer toute attaque de type injection SQL et XSS
    //$username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
    //$password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    
    if($pseudo !== "" && $pass !== "") {
      $query = $bdd->prepare("SELECT COUNT(*) FROM membres WHERE pseudo='$pseudo'");
      $query->execute;
      $count = $query->fetch();
        if(count($count) == 1) // si l'utilisateur existe
        {
           $_SESSION['pseudo'] = $pseudo;
           header('Location: index.php');
        }
        else
        {
           header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
        }
    }
    else
    {
       header('Location: login.php?erreur=2'); // utilisateur ou mot de passe vide
    }
}
else
{
   header('Location: login.php');
}
?>
