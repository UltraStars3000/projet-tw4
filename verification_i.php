<?php

// on récupère les valeurs entrées dans le formulaire
$pseudo = $_POST['pseudo'];
$pass = $_POST['pass'];

$pass = password_hash($pass, PASSWORD_DEFAULT);

//création automatique de la table membres:
//$creation = "CREATE TABLE IF NOT EXISTS 'membres' ( 'id_membre' INT NOT NULL AUTO_INCREMENT , 'pseudo' VARCHAR(40) NOT NULL , 'mdp' VARCHAR(100) NOT NULL , PRIMARY KEY ('id_membre'))";

//traitement du formulaire:
if (isset($pseudo, $pass)) { //l'utilisateur à cliqué sur "S'inscrire", on demande donc si les champs sont définis avec "isset"
    //connexion à la base de données:
    include "connexion.php";
    $query = $bdd->prepare("SELECT COUNT(*) FROM membres WHERE pseudo='$pseudo'");
    $query->execute();
    $count = $query->fetch(); // on récupère le nombre d'occurences du pseudo donné

    if (empty($pseudo)) { //le champ pseudo est vide, on arrête l'exécution du script et on affiche un message d'erreur
        echo "Le champ Pseudo est vide.";
    } elseif (strlen($pseudo) > 25) { //le pseudo est trop long, il dépasse 25 caractères
        echo "Le pseudo est trop long, il dépasse 25 caractères.";
    } elseif (empty($pass)) { //le champ mot de passe est vide
        echo "Le champ Mot de passe est vide.";
    } elseif (count($count) == 1) { //on vérifie que ce pseudo n'est pas déjà utilisé par un autre membre
        echo "Ce pseudo est déjà utilisé.";
    } else {
        //toutes les vérifications sont faites, on passe à l'enregistrement dans la base de données:
        //Bien évidement il s'agit là d'un script simplifié au maximum, libre à vous de rajouter des conditions avant l'enregistrement comme la longueur minimum du mot de passe par exemple
        $req = $bdd->prepare("INSERT INTO membres (pseudo, mdp) VALUES ('$pseudo', '$pass')");
        if (!$req->execute()) { //on insère les données dans la table
            echo "Une erreur s'est produite : ", $req->errorCode();
        } else {
            header('Location: index.php');
        }
    }
}
