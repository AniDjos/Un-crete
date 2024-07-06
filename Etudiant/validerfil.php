<?php
include 'connect.php';

// Fonction pour vérifier les ponctuations en début de chaîne et les espaces uniquement
function invalidInput($str)
{
    return preg_match('/^[[:punct:]]/', $str) || preg_match('/^\s+$/', $str);
}

if (isset($_POST['sigle']) && isset($_POST['libefil'])) {
    $sigle = trim($_POST['sigle']);
    $libefil = trim($_POST['libefil']);

    if (invalidInput($sigle) || invalidInput($libefil)) {
        echo json_encode(['status' => 'error', 'message' => 'Entrée invalide.']);
    } else {
        $requete = "SELECT * FROM filiere WHERE libefil = :libefil";
        $stmt = $bdd->prepare($requete);
        $stmt->bindParam(':libefil', $libefil);
        $stmt->execute();
        $donnees = $stmt->fetchAll();

        if ($donnees) {
            echo json_encode(['status' => 'error', 'message' => 'La filière existe déjà.']);
        } else {
            $requete = "INSERT INTO filiere (sigle, libefil) VALUES (:sigle, :libefil)";
            $stmt = $bdd->prepare($requete);
            $stmt->bindParam(':sigle', $sigle);
            $stmt->bindParam(':libefil', $libefil);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Filière enregistrée avec succès.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Échec de l\'ajout.']);
            }
        }
    }
}
?>
