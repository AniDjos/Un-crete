<?php
// Appel au fichier connect
include 'connect.php';

// Vérifier si les données du formulaire sont soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $id = $_POST['id'];
    $sigle = $_POST['sigle'];
    $libele = $_POST['libele'];

    // Validation minimale côté serveur (vous pouvez ajouter d'autres validations selon vos besoins)
    if (empty($sigle) || empty($libele)) {
        $response = [
            'status' => 'error',
            'message' => 'Tous les champs sont requis.'
        ];
    } else {
        // Préparer la requête de mise à jour de la filière
        $requete = "UPDATE filiere SET sigle = :sigle, libefil = :libele WHERE sigle = :id";
        $commande = $bdd->prepare($requete);
        $commande->bindParam(':sigle', $sigle);
        $commande->bindParam(':libele', $libele);
        $commande->bindParam(':id', $id);

        // Exécuter la commande
        if ($commande->execute()) {
            // Mise à jour réussie
            $response = [
                'status' => 'success',
                'message' => 'La filière a été modifiée avec succès.'
            ];
        } else {
            // Erreur lors de la mise à jour
            $response = [
                'status' => 'error',
                'message' => 'Une erreur s\'est produite lors de la modification de la filière.'
            ];
        }
    }
} else {
    // Méthode de requête incorrecte
    $response = [
        'status' => 'error',
        'message' => 'Méthode de requête incorrecte.'
    ];
}

// Retourner la réponse au format JSON
echo json_encode($response);
?>
