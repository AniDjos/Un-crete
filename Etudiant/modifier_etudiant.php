<?php
// Include database connection
include 'connect.php';

// Préparer la requête
$requete = "SELECT * FROM filiere WHERE filiere_inactive = 0 ORDER BY sigle";

// Exécuter la requête
$reponse = $bdd->query($requete);

// Récupérer les données de la requête
$donnees = $reponse->fetchAll(PDO::FETCH_ASSOC);

// Récupérer l'ID de l'étudiant à modifier depuis la requête GET
if (isset($_GET['id'])) {
    $matricule = htmlspecialchars($_GET['id']);

    // Préparer la requête pour récupérer les informations de l'étudiant
    $requete_etudiant = "SELECT * FROM etudiant WHERE matricule = :matricule";
    $stmt = $bdd->prepare($requete_etudiant);
    $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR);
    $stmt->execute();
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        // Rediriger si l'étudiant n'existe pas
        header('Location: listetudiant.php');
        exit();
    }
} else {
    // Si l'ID n'est pas présent dans la requête GET, rediriger ou afficher une erreur
    header('Location: listetudiant.php'); // Exemple de redirection vers une liste d'étudiants
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../Css/tables.css">
</head>
<body >
    <?php require __DIR__ . '/entetetudiant.php';?>

    <div class="container mt-4 p-3">
        <h1 class="text-center mb-4 fs-2">Modifier un étudiant</h1>
        <form id="formulaireModifierEtudiant" action="validermod_etudiant.php" method="post" >
            <input type="hidden" name="matricule" value="<?= htmlspecialchars($etudiant['matricule']) ?>">
            <div class="row w-50 m-auto">
                <!-- Gauche du formulaire -->
                
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email<span class="text-danger">*</span>:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($etudiant['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="lieunais" class="form-label">Lieu de naissance<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="lieunais" name="lieunais" value="<?= htmlspecialchars($etudiant['lieunais']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="datenais" class="form-label">Date nais<span class="text-danger">*</span>:</label>
                            <input type="date" class="form-control" id="datenais" name="datenais" value="<?= htmlspecialchars($etudiant['datenais']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="age" class="form-label">Âge<span class="text-danger">*</span>:</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?= htmlspecialchars($etudiant['age']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="sexe" class="form-label">Sexe<span class="text-danger">*</span>:</label>
                            <select class="form-select" id="sexe" name="sexe" required>
                                <option value="Masculin" <?= ($etudiant['sexe'] === 'Masculin') ? 'selected' : '' ?>>Masculin</option>
                                <option value="Féminin" <?= ($etudiant['sexe'] === 'Féminin') ? 'selected' : '' ?>>Féminin</option>
                            </select>
                        </div>
                    </div>
               
                    <div class="mb-3">
                        <label for="filiere" class="form-label">Filière<span class="text-danger">*</span>:</label>
                        <select class="form-control mb-4" id="filiere" name="filiere" required>
                            <?php foreach ($donnees as $filiere): ?>
                                <option value="<?= htmlspecialchars($filiere['sigle']) ?>" <?= ($etudiant['filiere'] === $filiere['sigle']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($filiere['sigle']) . " : " . htmlspecialchars($filiere['libefil']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>  
                </div>                 
  
            </div>
            
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../script/modifier_etudiant.js"></script>
</body>
</html>
