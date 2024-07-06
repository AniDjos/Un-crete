<?php

// Connexion à la base de données
include 'connect.php';

// Classe Etudiant
class Etudiant
{
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $sexe;
    private $age;
    private $datenais;
    private $lieunais;
    private $photo;
    private $filiere;

    private $mot;

    public function __construct($id, $nom, $prenom, $email, $sexe, $age, $datenais, $lieunais, $photo, $filiere , $mot)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->sexe = $sexe;
        $this->age = $age;
        $this->datenais = $datenais;
        $this->lieunais = $lieunais;
        $this->photo = $photo;
        $this->filiere = $filiere;
        $this->mot = $mot;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getSexe() { return $this->sexe; }
    public function getAge() { return $this->age; }
    public function getDatenais() { return $this->datenais; }
    public function getLieunais() { return $this->lieunais; }
    public function getPhoto() { return $this->photo; }
    public function getFiliere() { return $this->filiere; }
    public function getMot() { return $this->mot; }

    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setEmail($email) { $this->email = $email; }
    public function setSexe($sexe) { $this->sexe = $sexe; }
    public function setAge($age) { $this->age = $age; }
    public function setDatenais($datenais) { $this->datenais = $datenais; }
    public function setLieunais($lieunais) { $this->lieunais = $lieunais; }
    public function setPhoto($photo) { $this->photo = $photo; }
    public function setFiliere($filiere) { $this->filiere = $filiere; }
    public function setMot($mot) { $this->mot = $mot; }
}

// Fonction pour vérifier si une chaîne commence par une ponctuation
function startsWithPunctuation($str) {
    return preg_match('/^[[:punct:]]/', $str);
}

// Récupération des données
$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$sexe = $_POST['sexe'];
$age = intval($_POST['age']);
$datenais = $_POST['datenais'];
$lieunais = trim($_POST['lieunais']);
$filiere = $_POST['filiere'];
$mot = htmlspecialchars($_POST['mot']);
$photo = basename($_FILES['photo']['name']);
$dossier = "../photo/";
$chemin = $dossier . $photo;

// Génération du nouveau ID
$requete_last_id = "SELECT matricule FROM etudiant ORDER BY matricule DESC LIMIT 1";
$reponse_last_id = $bdd->query($requete_last_id);
$dernier_id = $reponse_last_id->fetch();
$nouveau_id = $dernier_id ? 'E' . str_pad(intval(substr($dernier_id['matricule'], 1)) + 1, 3, '0', STR_PAD_LEFT) : 'E001';

// Vérifications des données
function verifierDonnees($nom, $prenom, $email, $sexe, $age, $datenais, $lieunais, $filiere ,$mot) {
    if (empty($nom) || empty($prenom) || empty($email) || empty($sexe) || empty($age) || empty($datenais) || empty($lieunais) || empty($filiere) || empty($mot)) {
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
    return null;
}

$erreur = verifierDonnees($nom, $prenom, $email, $sexe, $age, $datenais, $lieunais, $filiere , $mot);
if ($erreur) {
    echo json_encode(['status' => 'error', 'message' => $erreur]);
    exit();
}

// Contrôle de doublon
$requete1 = $bdd->prepare("SELECT * FROM etudiant WHERE matricule = :matricule");
$requete1->execute(['matricule' => $nouveau_id]);
$donnees1 = $requete1->fetchAll();
if ($donnees1) {
    echo json_encode(['status' => 'error', 'message' => 'Ce matricule existe déjà.']);
    exit();
}

// Contrôle de doublon
$requete2 = $bdd->prepare("SELECT * FROM etudiant WHERE email = :email");
$requete2->execute(['email' => $email]);
$donnees2 = $requete2->fetchAll();
if ($donnees2) {
    echo json_encode(['status' => 'error', 'message' => 'L\'email existe déjà']);
    exit();
}


$etudiant = new Etudiant($nouveau_id, $nom, $prenom, $email, $sexe, $age, $datenais, $lieunais, $photo, $filiere, $mot);

// Préparation et exécution de la requête d'insertion
$requete = $bdd->prepare("INSERT INTO etudiant (matricule, nom, prenom, email, sexe, age, datenais, lieunais, photo, filiere ,mot) VALUES (:matricule, :nom, :prenom, :email, :sexe, :age, :datenais, :lieunais, :photo, :filiere , :mot)");
$resultat = $requete->execute([
    'matricule' => $etudiant->getId(),
    'nom' => $etudiant->getNom(),
    'prenom' => $etudiant->getPrenom(),
    'email' => $etudiant->getEmail(),
    'sexe' => $etudiant->getSexe(),
    'age' => $etudiant->getAge(),
    'datenais' => $etudiant->getDatenais(),
    'lieunais' => $etudiant->getLieunais(),
    'photo' => $etudiant->getPhoto(),
    'filiere' => $etudiant->getFiliere(),
    'mot' => $etudiant->getMot()
]);

if ($resultat) {
    move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
    echo json_encode(['status' => 'success', 'message' => 'Étudiant enregistré avec succès.']);
} else {
    echo json_encode(['status' => 'error', 'message' => "Une erreur s'est produite lors de l'enregistrement de l'étudiant."]);
}

?>