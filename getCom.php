<?php


include "connexion.php";
$reponse =  $bdd->query('SELECT * FROM commentaires');

while($donnees = $reponse->fetch()){
    $tab_id_commentaire[$donnees['id_commentaire']] = $donnees['id_commentaire'];
    $tab_nomLieux[$donnees['id_commentaire']] = $donnees['nom_lieux'];
    $tab_commentaire[$donnees['id_commentaire']] = $donnees['commentaire'];
    $tab_pseudo[$donnees['id_commentaire']] = $donnees['pseudo'];
    $tab_temps[$donnees['id_commentaire']] = $donnees['temps'];
}


foreach($tab_id_commentaire as $id_comm => $id){
    echo $tab_nomLieux[$id].";".$tab_commentaire[$id].";".$tab_pseudo[$id].";".$tab_temps[$id]."|";
}

?>