<?php
// Appel au fichier connect
include 'connect.php';

// Préparer la requête
$requete = "SELECT * FROM filiere WHERE filiere_inactive = 0 ORDER BY sigle";

// Exécuter la requête
$reponse = $bdd->query($requete);

// Récupérer les données de la requête
$donnees = $reponse->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../Css/tables.css">
    <title>LISTE-FILIERE</title>
</head>
<body>
    <?php include 'entetetudiant.php'; ?>

    <div class="container mt-4 p-4 bg-light rounded-3">
        <button type="button" id="afficherFormulaireBtn" class="btn btn-primary">Ajouter Filière</button> <span class="fs-5 text-primary">Gestion des filières</span>
        <div id="formulaire"  class="text-decoration-none mt-4 w-50 m-auto">
            <form id="formulaireFiliere" action="" method="post" enctype="multipart/form-data">
                <h1 class="text-center mb-4 fs-2">Ajouter une filière</h1>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="id" class="form-label">Sigle:</label>
                                <input type="text" class="form-control" id="id" name="sigle" required>
                            </div>
                            <div class="mb-3">
                                <label for="nom" class="form-label">Libellé:</label>
                                <input type="text" class="form-control" id="nom" name="libefil" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
</div>
        <h1 class="text-center mt-5 mb-3">Gestion des filières</h1>
        <div style="width:75%; margin-left:auto; margin-right:auto">
            <table id="tableEtudiants" class="table table-striped">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Libellé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donnees as $filiere): ?>
                        <tr>
                            <td><?= htmlspecialchars($filiere['sigle']) ?></td>
                            <td><?= htmlspecialchars($filiere['libefil']) ?></td>
                            <td>
                                <a href="modifier_filiere.php?id=<?= $filiere['sigle'] ?>">
                                    <i class="bi bi-pen-fill p-2 bg-success text-white rounded-pill"></i>
                                </a>
                                <a href="#" class="delete-btn" data-id="<?= htmlspecialchars($filiere['sigle']) ?>">
                                    <i class="bi bi-trash-fill p-2 bg-danger text-white rounded-pill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script src="../script/data_table.js"></script>
    <script src="../script/filiere.js"></script>
    <script src="../script/supprimer_filiere.js"></script>

</body>
</html>
