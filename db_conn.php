<?php

// Définition des informations de connexion à la base de données
// Definition of the database connection information
$sName = "localhost"; // Nom du serveur
// Server name
$uName = "florent"; // Nom d'utilisateur de la base de données
// Database username
$pass = "123456789"; // Mot de passe de la base de données
// Database password
$db_name = "ToDoPHP"; // Nom de la base de données
// Database name

try {
    // Tentative de connexion à la base de données
    // Attempting to connect to the database
    $conn = new PDO("mysql:host=$sName; dbname=$db_name", $uName, $pass);
    // Définition du mode de rapport d'erreurs pour la connexion PDO
    // Setting the error reporting mode for the PDO connection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Affichage d'un message d'erreur en cas d'échec de la connexion
    // Displaying an error message in case of connection failure
    echo "Connection failed: " . $e->getMessage();
}

?>
