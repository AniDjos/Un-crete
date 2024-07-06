<?php
// Include database connection
include 'connect.php';

// Fetch active students
$requete = "SELECT * FROM etudiant WHERE etudiant_inactif = 0 ORDER BY Matricule";
$reponse = $bdd->query($requete);
$etudiants = $reponse->fetchAll();

// Fetch filieres
$requete1 = "SELECT * FROM filiere where filiere_inactive = 0 ORDER BY fil_id DESC";
$reponse1 = $bdd->query($requete1);
$filieres = $reponse1->fetchAll();

// Fetch last student ID
$requete_last_id = "SELECT matricule FROM etudiant ORDER BY matricule DESC LIMIT 1";
$reponse_last_id = $bdd->query($requete_last_id);
$dernier_id = $reponse_last_id->fetch();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../Css/tables.css">
    <style>
        /* Add custom styles here */
    </style>
</head>
<body>
    <?php require __DIR__ . '/entetetudiant.php';?>

    <div class="container mt-4 p-4 bg-light rounded-3">
        <button type="button" id="afficherFormulaireBtn" class="btn btn-primary">Ajouter Etudiant</button> <span class="fs-5 text-primary">Gestion des étudiants</span>
        <div id="formulaire" style="display: none; margin-top: 20px;">
            <form id="formulaireEnregistrementEtudiant" action="" method="post" enctype="multipart/form-data">
                <h1 class="text-center mb-4 fs-1 mt-4">Formulaire d'enregistrement d'étudiant</h1>
                <div class="row">
                    <!-- Left part of the form -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span>:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="datenais" class="form-label">Date de naissance<span class="text-danger">*</span>:</label>
                            <input type="date" class="form-control" id="datenais" name="datenais" required>
                        </div>
                    </div>
                    <!-- Right part of the form -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="prenom" class="form-label">Prénom<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                        <div class="mb-3">
                            <label for="lieunais" class="form-label">Lieu de naissance<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="lieunais" name="lieunais" required>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo:</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        </div>
                    </div>
                    <!-- Additional section -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="sexe" class="form-label">Sexe<span class="text-danger">*</span>:</label>
                            <select class="form-select" id="sexe" name="sexe" required>
                                <option value="Masculin">Masculin</option>
                                <option value="Féminin">Féminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="age" class="form-label">Âge<span class="text-danger">*</span>:</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="filiere" class="form-label">Filière<span class="text-danger">*</span>:</label>
                            <div class="d-flex">
                                <select class="form-control" id="filiere" name="filiere" required>
                                    <?php foreach ($filieres as $filiere) {?>
                                        <option value="<?=htmlspecialchars($filiere['sigle'])?>"><?=htmlspecialchars($filiere['sigle']) . " : " . htmlspecialchars($filiere['libefil'])?></option>
                                    <?php }?>
                                </select>
                                <!-- Button to open modal -->
                                <button type="button" class="btn btn-primary mt-0 ml-3" data-bs-toggle="modal" data-bs-target="#formModal"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mdp" class="form-label">Mot de Passe<span class="text-danger">*</span>:</label>
                            <input type="password" class="form-control" id="" name="mot" >
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Ajouter une filière</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form in modal -->
                    <form id="formulaireModale" method="post" action="">
                        <div class="form-group">
                            <label for="sigle">Sigle</label>
                            <input type="text" class="form-control" id="sigle" name="sigle" required>
                        </div><br>
                        <div class="form-group">
                            <label for="libefil">Libellé</label>
                            <input type="text" class="form-control" id="libefil" name="libefil" required>
                        </div><br>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h3 class="text-center mt-5 mb-3">Liste des étudiants</h3>
    <div style="width:95%; margin-left:auto; margin-right:auto;">
        <table id="Etudiants" class="table table-striped">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Sexe</th>
                    <th>Âge</th>
                    <th>Date nais</th>
                    <th>Lieu nais</th>
                    <th>Filière</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant): ?>
                    <tr>
                        <td><?=htmlspecialchars($etudiant['matricule'])?></td>
                        <td><?=htmlspecialchars($etudiant['nom'])?></td>
                        <td><?=htmlspecialchars($etudiant['prenom'])?></td>
                        <td><?=htmlspecialchars($etudiant['email'])?></td>
                        <td><?=htmlspecialchars($etudiant['sexe'])?></td>
                        <td><?=htmlspecialchars($etudiant['age'])?> ans</td>
                        <td><?=htmlspecialchars($etudiant['datenais'])?></td>
                        <td><?=htmlspecialchars($etudiant['lieunais'])?></td>
                        <td><?=htmlspecialchars($etudiant['filiere'])?></td>
                        <td><img src="../photo/<?=htmlspecialchars($etudiant['Photo'])?>" alt="Photo" class="img-thumbnail"></td>
                        <td>
                            <a href="modifier_etudiant.php?id=<?=htmlspecialchars($etudiant['matricule'])?>"><i class="bi bi-pen-fill p-2 bg-success text-white rounded-circle"></i></a>
                            <a href="#" class="delete-btn" data-id="<?=htmlspecialchars($etudiant['matricule'])?>"><i class="bi bi-trash-fill p-2 bg-danger text-white rounded-circle"></i></a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script/supprimer_etudiant.js"></script>
    <script src="../script/etudiant.js"></script>
    <script src="../script/modale.js"></script>

    <script>
        document.getElementById("afficherFormulaireBtn").addEventListener("click", function() {
            var formulaire = document.getElementById("formulaire");
            formulaire.style.display = (formulaire.style.display === "none") ? "block" : "none";
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#Etudiants').DataTable();
        });
    </script>


</body>
</html>
