<?php include "layout/header.php" ?> <!-- Inclusion du header avec HTML, CSS et balises meta -->

<?php
    require_once "./config/db.php"; // Inclusion du fichier de configuration de base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Vérification que tous les champs existent

    $connexion = connect_pdo(); // Connexion à la base de données via PDO

    $sql = ("INSERT INTO utilisateurs (login,nom,prenom,password) VALUES (?,?,?,?)"); // Requête SQL avec placeholders sécurisés
    $login = ($_POST["login"]);
    $prenom = ($_POST["prenom"]);
    $nom = ($_POST["nom"]);
    $password = ($_POST["password"]);
    $password_hash = password_hash($mdp, PASSWORD_BCRYPT);

    $inscription = $connexion->prepare($sql); //</body> Préparation de la requête pour éviter les injections SQL

    try {
        $inscription->execute([$login, $prenom, $nom, $password_hash]); // Exécution avec les données du formulaire
        header("Location: connexion.php");
        exit();
    } catch (PDOException $erreur) {
        if ($erreur->getCode() == 23000) {
            $error = " Tu es bidon, ça existe déjà couillon";
        } else {
            $error = "Erreur : " . $erreur->getMessage();
        }
    }
}

?>


<h1></i> ACCUEIL</h1>
<p>Système d'authentification</p>
<form action="" method="POST">
    <label for="prenom">Prénom</label>
    <input placeholder="Prénom" type="text" id="prenom" name="prenom" required>

    <label for="nom">Nom</label>
    <input placeholder="Nom de famille" type="text" id="nom" name="nom" required>

    <label for="login">Nom d'utilisateur</label>
    <input placeholder="Nom d'utilisateur" type="text" id="login" name="login" required>

    <label for="password"> Mot de passe </label>
    <input placeholder="Mot de passe" type="password" id="password" name="password" required>

    <input placeholder="Confirmer mot de passe" type="password" name="passeword_hash" required>

    <button type="submit">S'inscrire</button>
</form>
</div>
</div>

<?php include "layout/footer.php"; ?> <!-- Inclusion du footer avec la fermeture HTML -->