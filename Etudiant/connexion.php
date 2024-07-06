<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-5 fs-2">Connectez-vous à votre compte</h1>
        <form id="formulaireConnexion" action="" method="post">
        <div class="col-mb-12 w-50 m-auto">
            <div class="mb-3">
                <label for="email" class="form-label">Email<span class="text-danger">*</span>:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="motdepasse" class="form-label">Mot de passe<span class="text-danger">*</span>:</label>
                <input type="password" class="form-control" id="motdepasse" name="mdp" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../script/connexion.js"></script>
</body>
</html>
