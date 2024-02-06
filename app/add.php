<?php

// Vérifie si le formulaire a été soumis
// Check if the form has been submitted
if (isset($_POST['title'])) {
    // Inclusion de la connexion à la base de données
    // Including the database connection
    require '../db_conn.php';

    // Récupère le titre depuis le formulaire
    // Get the title from the form
    $title = $_POST['title'];

    // Vérifie si le champ du titre est vide
    // Check if the title field is empty
    if (empty($title)) {
        // Redirige vers la page d'accueil avec un message d'erreur
        // Redirect to the home page with an error message
        header("Location: ../index.php?mess=error");
    } else {
        // Prépare la requête d'insertion
        // Prepare the insertion query
        $stmt = $conn->prepare("INSERT INTO todos(title) VALUE(?)");
        // Exécute la requête d'insertion avec le titre en paramètre
        // Execute the insertion query with the title as a parameter
        $res = $stmt->execute([$title]);

        // Vérifie si l'insertion a réussi
        // Check if the insertion was successful
        if ($res) {
            // Redirige vers la page d'accueil avec un message de succès
            // Redirect to the home page with a success message
            header("Location:../index.php?mess=success");
        } else {
            // Redirige vers la page d'accueil en cas d'erreur
            // Redirect to the home page in case of error
            header("Location: ../index.php");
        }
        // Ferme la connexion à la base de données
        // Close the database connection
        $conn = null;
        // Termine le script
        // Exit the script
        exit();
    }
} else {
    // Redirige vers la page d'accueil avec un message d'erreur si le formulaire n'a pas été soumis
    // Redirect to the home page with an error message if the form has not been submitted
    header("Location:../index.php?mess=error");
}

?>