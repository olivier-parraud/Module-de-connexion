<?php include "layout/header.php" ?> <!-- Inclusion du header avec HTML, CSS et balises meta -->

<?php
require_once "./config/db.php"; // Inclusion du fichier de configuration de base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Vérification que le formulaire a été soumis via POST

    $connexion = connect_pdo(); // Établissement de la connexion à la base de données via PDO

    $sql = "INSERT INTO utilisateurs (login,nom,prenom,password) VALUES (?,?,?,?)"; // Requête SQL avec placeholders sécurisés

    // Récupération des données du formulaire
    $login = $_POST["login"];           // Nom d'utilisateur saisi
    $prenom = $_POST["prenom"];         // Prénom de l'utilisateur
    $nom = $_POST["nom"];               // Nom de famille de l'utilisateur
    $password = $_POST["password"];     // Mot de passe en clair
    $password_hash = password_hash($password, PASSWORD_BCRYPT); // Hachage sécurisé du mot de passe avec bcrypt

    $stmt = $connexion->prepare($sql); // Préparation de la requête SQL pour éviter les injections SQL

    try {
        // Exécution de la requête avec les données saisies dans le formulaire
        $stmt->execute([$login, $prenom, $nom, $password_hash]);

        // Redirection vers la page de connexion après inscription réussie
        header("Location: connexion.php");
        exit(); // Arrêt du script après redirection

    } catch (PDOException $erreur) {
        // Gestion des erreurs lors de l'insertion
        if ($erreur->getCode() == 23000) {
            // Erreur de contrainte unique (login déjà existant)
            $error = " Tu es bidon, ça existe déjà couillon";
        } else {
            // Autres types d'erreurs de base de données
            $error = "Erreur : " . $erreur->getMessage();
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"];
    $prenom = $_POST["prenom"];
    $nom = $_POST["nom"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"]; // Récupération du champ confirmation

    // ✅ VALIDATION : Vérifier que les mots de passe correspondent
    if ($password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas !";
    } else {
        // Continuer avec l'inscription seulement si les mots de passe correspondent
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        // ... reste du code d'inscription
    }
}
?>

<!-- Page d'inscription des nouveaux utilisateurs -->
<h1></i> ACCUEIL</h1>
<p>Système d'authentification</p>

<!-- Formulaire d'inscription soumis vers la même page (action="") -->
<form action="" method="POST">
    <!-- Champ pour le prénom de l'utilisateur -->
    <label for="prenom">Prénom</label>
    <input placeholder="Prénom" type="text" id="prenom" name="prenom" required>

    <!-- Champ pour le nom de famille -->
    <label for="nom">Nom</label>
    <input placeholder="Nom de famille" type="text" id="nom" name="nom" required>

    <!-- Champ pour le nom d'utilisateur (doit être unique) -->
    <label for="login">Nom d'utilisateur</label>
    <input placeholder="Nom d'utilisateur" type="text" id="login" name="login" required>

    <!-- Champ pour le mot de passe -->
    <label for="password"> Mot de passe </label>
    <input placeholder="Mot de passe" type="password" id="password" name="password" required>

    <!-- Champ de confirmation du mot de passe (attention: le name semble incorrect) -->
<input placeholder="Confirmer mot de passe" type="password" name="password_confirm" required>
    <!-- Bouton de soumission du formulaire -->
    <button type="submit">S'inscrire</button>
</form>
</div>
</div>

<?php include "layout/footer.php"; ?> <!-- Inclusion du footer avec la fermeture HTML -->