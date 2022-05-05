<?php
    include "connexion.php";
    //requête pour récuperer les data des monuments stockés dans la BDD msql
    $reponse =  $bdd->query('SELECT * FROM lieux');

    //on stocke les données des monuments dans des tableaux
    while($donnees = $reponse->fetch()){
        $tab_categorie[$donnees['id_lieux']] = $donnees['categorie'];
        $tab_nom[$donnees['id_lieux']] = $donnees['nom'];
        $tab_note[$donnees['id_lieux']] = $donnees['note'];
        $tab_nbVote[$donnees['id_lieux']] = $donnees['nbVotes'];
    }

    //pour chaque monument, on crée une chaine de caractères avec toutes les données séparées d'un ;
    //chaque monument est séparé d'un |
    //dans le fichier script.js on vient faire une requête ajax en GET pour récuperer ces données
    foreach($tab_nom as $id_monu => $nom){
        //construction d'une chaine de caractères
        echo $nom.";".$tab_categorie[$id_monu].";".$tab_note[$id_monu].";".$tab_nbVote[$id_monu]."|";
        
    }
?>