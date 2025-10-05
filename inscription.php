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
    $password_confirm = $_POST["password_confirm"]; // Confirmation du mot de passe

    // Validation : Vérifier que les mots de passe correspondent
    if ($password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas !";
    } else {
        // Les mots de passe correspondent, on peut procéder à l'inscription
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
    } // Fin du else (mots de passe correspondent)
} // Fin du if (REQUEST_METHOD === POST)
?>

<!-- Page d'inscription des nouveaux utilisateurs -->
<!-- Wrapper de centrage : centre verticalement et horizontalement le bloc -->
<div class="page-center">
<!-- Carte principale (effet verre, ombre, rayon) -->
<div class="container">


    <h1>INSCRIPTION</h1>
    <p>Créez votre compte</p>

    <!-- Affichage conditionnel des messages d'erreur -->
    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Formulaire d'inscription soumis vers la même page (action="") -->
    <form action="" method="POST">
        
        <!-- Champ pour le prénom de l'utilisateur -->
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input placeholder="Entrez votre prénom" type="text" id="prenom" name="prenom" required>
        </div>

        <!-- Champ pour le nom de famille -->
        <div class="form-group">
            <label for="nom">Nom</label>
            <input placeholder="Entrez votre nom de famille" type="text" id="nom" name="nom" required>
        </div>

        <!-- Champ pour le nom d'utilisateur (doit être unique) -->
        <div class="form-group">
            <label for="login">Nom d'utilisateur</label>
            <input placeholder="Choisissez un nom d'utilisateur" type="text" id="login" name="login" required>
        </div>

        <!-- Champ pour le mot de passe -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input placeholder="Créez un mot de passe" type="password" id="password" name="password" required>
        </div>

        <!-- Champ de confirmation du mot de passe -->
        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe</label>
            <input placeholder="Confirmez votre mot de passe" type="password" id="password_confirm" name="password_confirm" required>
        </div>

        <!-- Bouton de soumission du formulaire -->
        <button type="submit">S'inscrire</button>

    </form>
</div>
</div>

<?php include "layout/footer.php"; ?> <!-- Inclusion du footer avec la fermeture HTML -->