<?php

    $pdo = new PDO('mysql:host=localhost;dbname=favoris', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    // Affichage (SELECT) :
    
    if(isset($_GET['id_favori'])) {
        $record_id = $_GET['id_favori'];

        $requeteSQL = "DELETE FROM favori WHERE id_favori =". $_GET['id_favori'];
        // A decommenter si  suprimer
         $pdo->query($requeteSQL);
        // Votre code de suppression d'enregistrement ici...
        // Supposons que vous avez déjà supprimé l'enregistrement ici...
    
        // Vérifie si l'enregistrement a été supprimé avec succès
        // Par exemple, si vous avez utilisé une fonction de suppression de votre framework ORM ou une requête SQL DELETE
        // Vous pouvez remplacer cette condition par votre propre logique de suppression
        // Exemple :
        $is_deleted = true; // Supposons que l'enregistrement a été supprimé avec succès
    
        if ($is_deleted) {             
            echo "L'enregistrement a été supprimé avec succès.";
            header("Refresh: 3; URL=index.php");            
        } else {
            echo "Erreur lors de la suppression de l'enregistrement.";
            header("Refresh: 4; URL=index.php");
        }
    }


    