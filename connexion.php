<?php

session_start(); // Démarrage de la session pour pouvoir utiliser $_SESSION

require_once "./config/db.php"; // Inclusion du fichier de configuration de base de données

// $sql = ("INSERT INTO utilisateurs (login,nom,prenom,password) VALUES (?,?,?,?)"); // Requête SQL avec placeholders sécurisés

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Vérification que le formulaire a été soumis via POST
    // Récupération des données de connexion saisies par l'utilisateur
    $login = $_POST["login"];       // Nom d'utilisateur saisi
    $password = $_POST["password"]; // Mot de passe en clair saisi
    
    $pdo = connect_pdo(); // Établissement de la connexion à la base de données

    // Recherche de l'utilisateur dans la base de données par son login
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // Protection contre les injections SQL
    $stmt->execute([$login]); // Exécution de la requête avec le login saisi
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupération des données utilisateur sous forme de tableau associatif

    if ($user) { // Vérification si l'utilisateur existe dans la base de données
        // Vérification du mot de passe saisi contre le hash stocké en base
        if (password_verify($password, $user["password"])) {
            // Connexion réussie : stockage des informations en session
            $_SESSION["user_login"] = [$user["login"]];     // Sauvegarde du login en session
            $_SESSION["welcome_message"] = "Bienvenue en Enfer" . $user["login"] . "😈"; // Message de bienvenue personnalisé

            header("Location: profil.php"); // Redirection vers la page de profil après connexion réussie
            exit(); // Arrêt du script après redirection

        } else {
            // Mot de passe incorrect
            $error = "Identifiants incorrects.";
        }
    } else {
        // Utilisateur non trouvé
        $error = "Identifiants incorrects.";
    } // Fin de la vérification d'existence de l'utilisateur
} // Fin du traitement POST
?>

<!-- Page de connexion des utilisateurs -->
<h1>CONNEXION</h1>

<!-- Affichage conditionnel des messages d'erreur -->
<?php if (!empty($error)): ?>
    <div> <?php echo $error; ?> </div>
<?php endif; ?>

<!-- Formulaire de connexion soumis vers la même page -->
<form action="" method="POST">

    <!-- Champ pour saisir le nom d'utilisateur -->
    <label for="login">Nom d'utilisateur</label>
    <input placeholder="Nom d'utilisateur" type="text" id="login" name="login" required>

    <!-- Champ pour saisir le mot de passe -->
    <label for="password"> Mot de passe </label>
    <input placeholder="Mot de passe" type="password" id="password" name="password" required>

    <!-- Bouton de soumission du formulaire de connexion -->
    <button type="submit">Se Connecter</button>

</form>