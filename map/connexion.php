<?php
try {
    $bdd = new PDO('mysql:host=mysql-projetgroupecarte.alwaysdata.net;dbname=projetgroupecarte_lieux;charset=utf8', '261078', 'Test8181!');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
