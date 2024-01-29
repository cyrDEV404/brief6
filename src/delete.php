<?php

    $pdo = new PDO('mysql:host=localhost;dbname=favoris', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // Affichage (SELECT) :

    
    $requeteSQL = "DELETE FROM favori WHERE id_favori =". $_GET['id_favori'];
    // A decommenter si  suprimer
    //$delete = $pdo->query($requeteSQL);
    

    header('location:index.php')


    ?>