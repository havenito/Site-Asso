<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viva Association</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="menu-container">
            <a href="index.php">
                <img src="uploads/Capture_d_écran_2024-07-03_104432-removebg-preview (1).png" alt="Logo" class="logo">
            </a>
            <nav class="menu">
                <a href="index.php">Accueil</a>
                <a href="association.php">L'association</a>
                <a href="events.php">Événements</a>
                <a href="participate.php">Participer</a>
                <?php if (isLoggedIn()) { ?>
                    <a href="logout.php">Se déconnecter (<?php echo getUsername(); ?>)</a>
                <?php } else { ?>
                    <a href="login.php">Se connecter</a>
                    <a href="register.php">S'inscrire</a>
                <?php } ?>
            </nav>
        </div>
    </header>
    <main>