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
        // Affiche une erreur
        // Display an error
        echo 'error';
    } else {
        // Récupère la tâche à l'aide de l'identifiant
        // Retrieve the task using the ID
        $todos = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
        $todos->execute([$id]);

        // Récupère les données de la tâche
        // Fetch the task data
        $todo = $todos->fetch();
        $uId = $todo['id'];
        $checked = $todo['checked'];

        // Inverse l'état de la tâche (checked/non checked)
        // Invert the state of the task (checked/not checked)
        $uChecked = $checked ? 0 : 1;

        // Met à jour l'état de la tâche dans la base de données
        // Update the task state in the database
        $res = $conn->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        // Vérifie si la mise à jour a réussi
        // Check if the update was successful
        if ($res) {
            // Affiche l'état actuel de la tâche
            // Display the current state of the task
            echo $checked;
        } else {
            // Affiche une erreur en cas d'échec de la mise à jour
            // Display an error in case of update failure
            echo "error";
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
