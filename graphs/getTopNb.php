<?php
    include "../login-form-20/connexion.php";

    $reponse = $bdd->query('SELECT id_lieux, nom, nbVotes FROM lieux ORDER BY nbVotes DESC LIMIT 5');

    while($donnees = $reponse->fetch()){
        $tab_nom[$donnees['id_lieux']] = $donnees['nom'];
        $tab_nbVote[$donnees['id_lieux']] = $donnees['nbVotes'];
    }

    //On crée une chaîne de caractères avec tout les lieux, séparés d'un ;
    //Les lieux et leurs notes sont séparés d'un |
    //Dans le fichier script.js on vient faire une requête ajax pour récuperer ces données
    foreach($tab_nom as $id_monu => $nom){
        //construction d'une chaine de caractères
        echo $nom.";";
    }
    echo "|";
    foreach($tab_nom as $id_monu => $nom){
        echo $tab_nbVote[$id_monu].";";
    }
    echo "|"
?>