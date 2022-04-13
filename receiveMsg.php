<?php
$id = $_GET['id'];


include "connexion.php";
$sql = "SELECT m.*,u.id_utilisateurs, u.pseudo FROM messages m JOIN utilisateurs u ON u.id_utilisateurs = m.id_sender WHERE m.id_receiver = ? ";
$rqt = $bdd->prepare($sql);
$rqt->execute(array($id));
$messages = $rqt->fetchAll(PDO::FETCH_ASSOC);
foreach($messages as $message) {
    echo $message["pseudo"].";".$message['message'].";".$message['id_receiver'];
    $req = $bdd->prepare('DELETE FROM messages WHERE messages.id_message = :id');
    $res = $req->execute(array('id' => $message["id_message"]));
}