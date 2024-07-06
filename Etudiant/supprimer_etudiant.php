<?php
// Include database connection
include 'connect.php';

// Vérifie si l'ID de l'étudiant à supprimer est présent dans la requête GET
if (isset($_GET['id'])) {
    // Échapper l'ID pour éviter les injections SQL (meilleure pratique)
    $id = htmlspecialchars($_GET['id']);

    // Préparer la requête de suppression logique
    $requete = "UPDATE etudiant SET etudiant_inactif = TRUE WHERE matricule = :id";

    // Préparer et exécuter la requête en utilisant un statement préparé
    $stmt = $bdd->prepare($requete);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Succès de la suppression logique
        $response = [
            'status' => 'success',
            'message' => 'Étudiant supprimé avec succès!'
        ];
    } else {
        // Échec de la suppression
        $response = [
            'status' => 'error',
            'message' => 'Erreur lors de la suppression de l\'étudiant. Veuillez réessayer.'
        ];
    }
} else {
    // Si l'ID n'est pas présent dans la requête GET
    $response = [
        'status' => 'error',
        'message' => 'ID de l\'étudiant manquant.'
    ];
}

// Retourner la réponse JSON pour être traitée par JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
