<?php
// Appel au fichier connect
include 'connect.php';

// Vérifier si l'ID de la filière à supprimer est présent dans la requête POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Préparer la requête de mise à jour pour marquer la filière comme inactive
    $requete = "UPDATE filiere SET filiere_inactive = TRUE WHERE sigle = :id";

    // Préparer la commande SQL
    $commande = $bdd->prepare($requete);

    // Binder les paramètres
    $commande->bindParam(':id', $id);

    // Exécuter la commande
    if ($commande->execute()) {
        // Mise à jour réussie
        $response = [
            'status' => 'success',
            'message' => 'La filière a été marquée comme inactive avec succès.'
        ];
    } else {
        // Erreur lors de la mise à jour
        $response = [
            'status' => 'error',
            'message' => 'Une erreur s\'est produite lors de la mise à jour de la filière.'
        ];
    }

    // Retourner la réponse au format JSON
    echo json_encode($response);
} else {
    // ID non trouvé dans la requête POST
    $response = [
        'status' => 'error',
        'message' => 'ID de filière non spécifié.'
    ];
    echo json_encode($response);
}
?>
