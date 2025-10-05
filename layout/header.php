<?php
// Démarre/continue la session pour savoir si l'utilisateur est connecté
session_start();

// État de session & infos utilisateur
// On accepte deux conventions possibles: $_SESSION['user']['login'] OU $_SESSION['login']
$isLoggedIn = isset($_SESSION['user']) || isset($_SESSION['login']);
$username = isset($_SESSION['user']['login']) ? $_SESSION['user']['login'] : (isset($_SESSION['login']) ? $_SESSION['login'] : 'Invité');
$isAdmin = (
    isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'
) || (!empty($_SESSION['is_admin']));

// Page active (permet d'ajouter la classe .active au lien courant)
$active = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 ACCUEIL</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        
        <div class="nav-inner">
            <!-- Marque/logo du site -->
            <a class="brand" href="index.php">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Module de Connexion</span>
            </a>

            <!-- Toggle mobile sans JavaScript (checkbox + label) -->
            <input type="checkbox" id="nav-toggle" class="hamburger-toggle" aria-label="Ouvrir le menu">
            <label for="nav-toggle" class="hamburger" aria-hidden="true">
                <span></span><span></span><span></span>
            </label>

            <!-- Liens de navigation principaux -->
            <ul class="nav-links">
                <li><a class="<?= $active === 'index.php' ? 'active' : '' ?>" href="index.php">Accueil</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a class="<?= $active === 'profil.php' ? 'active' : '' ?>" href="profil.php">Profil</a></li>
                    <?php if ($isAdmin): ?>
                        <li><a class="<?= $active === 'admin.php' ? 'active' : '' ?>" href="admin.php">Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
                
            </ul>

            <!-- Actions à droite (connecté vs invité) -->
            <div class="nav-actions">
                <?php if ($isLoggedIn): ?>
                    <span class="user-badge"><i class="fa-regular fa-user"></i> <?= htmlspecialchars($username) ?></span>
                    <a class="btn btn-logout" href="profil.php?logout=1">Déconnexion</a>
                <?php else: ?>
                    <a class="btn" href="connexion.php">Se connecter</a>
                    <a class="btn btn-outline" href="inscription.php">Créer un compte</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>