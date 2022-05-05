<?php
$id = $_GET['id'];


include "connexion.php";

$reponse =  $bdd->query('SELECT * FROM messages WHERE messages.id_receiver = '.$id.'');


while($donnees = $reponse->fetch()){
    $tab_id_message[$donnees['id_message']] = $donnees['id_message'];
    $tab_id_sender[$donnees['id_message']] = $donnees['id_sender'];
    $tab_message[$donnees['id_message']] = $donnees['message'];
}
    
    
foreach($tab_id_message as $id_message => $id2){
        //construction d'une chaine de caractere
    $reponse2 =  $bdd->query('SELECT * FROM utilisateurs WHERE utilisateurs.id_utilisateurs = '.$tab_id_sender[$id_message].'');
     while($donnees2 = $reponse2->fetch()){
        $tab_id[$donnees2['id_utilisateurs']] = $donnees2['id_utilisateurs'];
        $tab_pseudo[$donnees2['id_utilisateurs']] = $donnees2['pseudo'];
    }

    foreach($tab_id as $id_pseudo => $id3){
        echo $tab_pseudo[$id3].";".$tab_message[$id_message];

    }
    
    
    
    
        $req = $bdd->prepare('DELETE FROM messages WHERE messages.id_message = :id');
        $res = $req->execute(array('id' => $id_message));
}


?>