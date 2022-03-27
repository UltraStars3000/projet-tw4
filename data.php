<?php
    include "connexion.php";
    //requete pour recuperer les data des monuments stockés dans la BDD msql
    $reponse =  $bdd->query('SELECT * FROM lieux');

    //on stocke les données des monuments dans des tableaux
    while($donnees = $reponse->fetch()){
        $tab_categorie[$donnees['id_lieux']] = $donnees['categorie'];
        $tab_addresse[$donnees['id_lieux']] = $donnees['addresse'];
        $tab_long[$donnees['id_lieux']] = $donnees['longitude'];
        $tab_lat[$donnees['id_lieux']] = $donnees['latitude'];
        $tab_nom[$donnees['id_lieux']] = $donnees['nom'];
    }

    //pour chaque monuments, on crée une chaine de carateres avec toutes les données séparées d'un ;
    //chaque monument est séparé d'un |
    //dans le fichier script.js on vient faire une requete ajax en GET pour recuperer ces données
    foreach($tab_nom as $id_monu => $nom){
        //construction d'une chaine de caractere
        echo $nom.";".$tab_long[$id_monu].";".$tab_lat[$id_monu].";".$tab_addresse[$id_monu].";".$tab_categorie[$id_monu]."|";
        
    }

    
    
    

    ?>
