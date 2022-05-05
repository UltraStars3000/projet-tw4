<?php
    include "connexion.php";
    //requête pour récuperer les data des monuments stockés dans la BDD msql
    $reponse =  $bdd->query('SELECT * FROM lieux');

    //on stocke les données des monuments dans des tableaux
    while($donnees = $reponse->fetch()){
        $tab_categorie[$donnees['id_lieux']] = $donnees['categorie'];
        $tab_addresse[$donnees['id_lieux']] = $donnees['addresse'];
        $tab_long[$donnees['id_lieux']] = $donnees['longitude'];
        $tab_lat[$donnees['id_lieux']] = $donnees['latitude'];
        $tab_nom[$donnees['id_lieux']] = $donnees['nom'];
        $tab_note[$donnees['id_lieux']] = $donnees['note'];
    }

    //pour chaque monument, on crée une chaine de caractères avec toutes les données séparées d'un ;
    //chaque monument est séparé d'un |
    //dans le fichier script.js on vient faire une requête ajax en GET pour récuperer ces données
    foreach($tab_nom as $id_monu => $nom){
        //construction d'une chaine de caractères
        echo $nom.";".$tab_long[$id_monu].";".$tab_lat[$id_monu].";".$tab_addresse[$id_monu].";".$tab_categorie[$id_monu].";".$tab_note[$id_monu]."|";
        
    }
?>