<?php
include 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $servername = "localhost";
    $username_db = "root";
    $password_db = "Enzolise1976."; 
    $dbname = "mirashow";
    $port = 3306;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Le nom d\\'utilisateur existe déjà. Veuillez en choisir un autre.');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            echo "<script>alert('Enregistrement réussi. Vous pouvez maintenant vous connecter.'); window.location.href = 'login.php';</script>";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <header>
        <div class="menu-container">
            <a href="index.php">
                <img src="uploads/Capture_d_écran_2024-07-03_104432-removebg-preview (1).png" alt="Logo" class="logo">
            </a>
            <nav class="menu">
                <a href="association.php">L'association</a>
                <a href="events.php">Événements</a>
                <a href="index.php">Inclusion</a>
                <a href="participate.php">Participer</a>
            </nav>
        </div>
    </header>
    <main>
        <h2>S'inscrire</h2>
        <form method="post" action="">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required  placeholder="Votre nom d'utilisateur">
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" placeholder="Votre mot de passe" class="form-control" required minlength=6 maxlength=30>
            <input type="submit" value="S'inscrire" class="mt-2 btn btn-primary">
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>