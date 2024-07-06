<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['mdp']);
    
    // Concaténation des données saisies
    $input_concat = $email . $password;
    //$input_hashed = hash('sha256', $input_concat); // Utiliser un algorithme de hachage sécurisé

    // Requête pour récupérer tous les étudiants
    $requete = "SELECT email, mot FROM etudiant";
    $stmt = $bdd->prepare($requete);
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $found = false;

    foreach ($etudiants as $etudiant) {
        $db_concat = $etudiant['email'] . $etudiant['mot'];
        //$db_hashed = hash('sha256', $db_concat); // Utiliser le même algorithme de hachage

        if ($input_concat === $db_concat) {
            $found = true;
            $_SESSION['email'] = $email;
            break;
        }
    }

    if ($found) {
        $response = [
            'status' => 'success',
            'message' => 'Connexion réussie!',
            'redirect' => 'listeetudiant.php'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Email ou mot de passe incorrect.'
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    $response = [
        'status' => 'error',
        'message' => 'Méthode non autorisée.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit(); 
}
?>
