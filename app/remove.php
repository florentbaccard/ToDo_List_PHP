<?php

// Vérifie si l'identifiant a été envoyé via POST
// Check if the ID has been sent via POST
if (isset($_POST['id'])) {
    // Inclusion de la connexion à la base de données
    // Including the database connection
    require '../db_conn.php';

    // Récupère l'identifiant depuis le formulaire
    // Get the ID from the form
    $id = $_POST['id'];

    // Vérifie si l'identifiant est vide
    // Check if the ID is empty
    if (empty($id)) {
        // Affiche 0 pour indiquer un problème avec l'identifiant
        // Display 0 to indicate an issue with the ID
        echo 0;
    } else {
        // Prépare la requête de suppression
        // Prepare the deletion query
        $stmt = $conn->prepare("DELETE FROM todos WHERE id=?");
        // Exécute la requête de suppression avec l'identifiant en paramètre
        // Execute the deletion query with the ID as a parameter
        $res = $stmt->execute([$id]);

        // Vérifie si la suppression a réussi
        // Check if the deletion was successful
        if ($res) {
            // Affiche 1 pour indiquer une suppression réussie
            // Display 1 to indicate successful deletion
            echo 1;
        } else {
            // Affiche 0 pour indiquer une erreur lors de la suppression
            // Display 0 to indicate an error occurred during deletion
            echo 0;
        }
        // Ferme la connexion à la base de données
        // Close the database connection
        $conn = null;
        // Termine le script
        // Exit the script
        exit();
    }
} else {
    // Redirige vers la page d'accueil avec un message d'erreur si l'identifiant n'a pas été envoyé
    // Redirect to the home page with an error message if the ID has not been sent
    header("Location: ../index.php?mess=error");
}

?>