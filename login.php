<?php
include_once 'session.php';

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

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                ?> 
            <div name="error_message">
                <p>Nom d'utilisateur ou mot de passe incorrect.</p>
            </div> <?php
            }
        } else {
            echo "<p style='color: red; position: fixed; bottom: 50px; left: 50%; transform: translateX(-50%); background-color: #ff5722; padding: 10px 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); font-size: 16px; font-weight: bold; z-index: 1001;'>Email ou mot de passe incorrect.</p>";
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
    <title>Se connecter</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
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
        <h2>Se connecter</h2>
        <form method="post" action="">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required  placeholder="Votre nom d'utilisateur">
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" placeholder="Votre mot de passe" class="form-control" required minlength=6 maxlength=30>
            <input type="submit" value="Se connecter" class="mt-2 btn btn-primary">
        </form>
        <p class="signup-link">Vous n'avez pas de compte ? <a href="register.php">S'inscrire</a></p>
    </main>
</body>
</html>
<?php include 'footer.php'; ?>