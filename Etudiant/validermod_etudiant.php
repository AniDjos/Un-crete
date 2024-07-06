<?php
// Include database connection
include 'connect.php';

// Vérifie si le formulaire a été soumis avec la méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et nettoyer les données du formulaire
    $matricule = htmlspecialchars($_POST['matricule'] ?? '');
    $nom = htmlspecialchars($_POST['nom'] ?? '');
    $prenom = htmlspecialchars($_POST['prenom'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $sexe = htmlspecialchars($_POST['sexe'] ?? '');
    $age = htmlspecialchars($_POST['age'] ?? '');
    $datenais = htmlspecialchars($_POST['datenais'] ?? '');
    $lieunais = htmlspecialchars($_POST['lieunais'] ?? '');
    $filiere = htmlspecialchars($_POST['filiere'] ?? '');

    // Fonction pour vérifier si une chaîne commence par une ponctuation
    function startsWithPunctuation($str)
    {
        return preg_match('/^[[:punct:]]/', $str);
    }

    // Fonction pour valider les données du formulaire
    function verifierDonnees($nom, $prenom, $email, $sexe, $age, $datenais, $lieunais, $filiere)
    {
        if (empty($nom) || empty($prenom) || empty($email) || empty($sexe) || empty($age) || empty($datenais) || empty($lieunais) || empty($filiere)) {
            return "Veuillez entrer toutes les données.";
        }

        $datenais_year = intval(substr($datenais, 0, 4));
        if ($datenais_year < 1985 || $datenais_year > 2009) {
            return "La date de naissance doit être comprise entre 1985 et 2009.";
        }

        $current_year = intval(date("Y"));
        $calculated_age = $current_year - $datenais_year;
        if ($calculated_age != $age) {
            return "L'âge ne correspond pas à l'année de naissance.";
        }

        if (preg_match('/^\s/', $nom) || preg_match('/^\s/', $prenom) || preg_match('/^\s/', $email) || preg_match('/^\s/', $lieunais) || startsWithPunctuation($nom) || startsWithPunctuation($prenom) || startsWithPunctuation($email) || startsWithPunctuation($lieunais)) {
            return "Les champs ne doivent pas commencer par des espaces ou des signes de ponctuation.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "L'adresse email n'est pas valide.";
        }

        return null; // Pas d'erreur
    }

    // Vérifier les données avec la fonction de validation
    $erreur = verifierDonnees($nom, $prenom, $email, $sexe, $age, $datenais, $lieunais, $filiere);
    if ($erreur) {
        echo json_encode(['status' => 'error', 'message' => $erreur]);
        exit();
    }

    // Préparer la requête de mise à jour
    $requete = "UPDATE etudiant SET 
                nom = :nom,
                prenom = :prenom,
                email = :email,
                sexe = :sexe,
                age = :age,
                datenais = :datenais,
                lieunais = :lieunais,
                filiere = :filiere
                WHERE matricule = :matricule";

    // Préparer et exécuter la requête en utilisant un statement préparé
    $stmt = $bdd->prepare($requete);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':sexe', $sexe, PDO::PARAM_STR);
    $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    $stmt->bindParam(':datenais', $datenais, PDO::PARAM_STR);
    $stmt->bindParam(':lieunais', $lieunais, PDO::PARAM_STR);
    $stmt->bindParam(':filiere', $filiere, PDO::PARAM_STR);
    $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR);

    // Exécuter la requête SQL
    if ($stmt->execute()) {
        // Succès de la mise à jour
        $response = [
            'status' => 'success',
            'message' => 'Étudiant modifié avec succès!'
        ];
    } else {
        // Échec de la mise à jour
        $response = [
            'status' => 'error',
            'message' => 'Erreur lors de la modification de l\'étudiant. Veuillez réessayer.'
        ];
    }
} else {
    // Si la méthode n'est pas POST, renvoyer une erreur
    $response = [
        'status' => 'error',
        'message' => 'Méthode non autorisée pour la modification de l\'étudiant.'
    ];
}

// Retourner la réponse JSON pour être traitée par JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>
