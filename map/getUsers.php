<?php
    include "connexion.php";
    //requete pour recuperer les data des utilisateurs stockés dans la BDD msql
    $reponse =  $bdd->query('SELECT * FROM utilisateurs');

    //on stocke les données des utilisateurs dans des tableaux
    while($donnees = $reponse->fetch()){
        $tab_id[$donnees['id_utilisateurs']] = $donnees['id_utilisateurs'];
        $tab_pseudo[$donnees['id_utilisateurs']] = $donnees['pseudo'];
        $tab_long[$donnees['id_utilisateurs']] = $donnees['longitude'];
        $tab_lat[$donnees['id_utilisateurs']] = $donnees['latitude'];
    }

    //pour chaque utilisateurs, on crée une chaine de carateres avec toutes les données séparées d'un ;
    //chaque utilisateurs est séparé d'un |
    //dans le fichier script.js on vient faire une requete ajax en GET pour recuperer ces données
    foreach($tab_id as $id_user => $id){
        //construction d'une chaine de caractere
        echo $id.";".$tab_pseudo[$id_user].";".$tab_long[$id_user].";".$tab_lat[$id_user]."|";
    }

    ?>