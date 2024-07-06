<?php
// Appel au fichier connect
include 'connect.php';

// Vérifier si l'ID de la filière à modifier est passé en paramètre GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour récupérer les informations de la filière à modifier
    $requete = "SELECT * FROM filiere WHERE sigle = :id";
    $commande = $bdd->prepare($requete);
    $commande->bindParam(':id', $id);
    $commande->execute();
    $filiere = $commande->fetch(PDO::FETCH_ASSOC);

    // Vérifier si la filière existe
    if (!$filiere) {
        // Rediriger ou afficher une erreur si la filière n'existe pas
        header('Location: modifier_filiere.php');
        exit;
    }
} else {
    // Rediriger si l'ID n'est pas spécifié
    header('Location: modifier_filiere.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../Css/tables.css">
    <title>Modifier Filière</title>
</head>
<body>
    <?php include 'entetetudiant.php'; ?>

    <div class="container mt-4 w-50 m-auto">
        <h1 class="text-center mb-4 fs-2">Modifier la filière</h1>
        <form id="formulaireModifierFiliere" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $filiere['sigle'] ?>">
            <div class="mb-3">
                <label for="id" class="form-label">Sigle:</label>
                <input type="text" class="form-control" id="id" name="sigle" value="<?= htmlspecialchars($filiere['sigle']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Libellé:</label>
                <input type="text" class="form-control" id="nom" name="libele" value="<?= htmlspecialchars($filiere['libefil']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script/modifier_filiere.js"></script>
</body>
</html>
