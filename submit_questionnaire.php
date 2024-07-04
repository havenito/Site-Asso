<?php include 'header.php'; ?>
    <div class="main-content">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $commentaires = htmlspecialchars($_POST['commentaires']);
            // Code pour traiter et enregistrer les commentaires
            echo "<p>Merci pour vos commentaires : " . $commentaires . "</p>";
        }
        ?>
    </div>
<?php include 'footer.php'; ?>