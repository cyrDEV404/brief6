<?php
$pdo = new PDO('mysql:host=localhost;dbname=favoris', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
// Affichage (SELECT) :
$result = $pdo->query("SELECT * FROM favori");
$favori = $result->fetch(PDO::FETCH_ASSOC); 

