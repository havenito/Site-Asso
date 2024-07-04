<?php include 'header.php'; ?>
<?php include_once 'session.php'; ?>

<?php
if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['event_id'])) {
    die("Événement non spécifié.");
}

$event_id = $_GET['event_id'];

$servername = "localhost";
$username_db = "root";
$password_db = "Enzolise1976.";
$dbname = "mirashow";

$successMessage = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT name, date, location FROM events WHERE id = :event_id");
    $stmt->bindParam(':event_id', $event_id);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        die("Événement introuvable.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['satisfaction']) && isset($_POST['rating'])) {
        $satisfaction = $_POST['satisfaction'];
        $rating = $_POST['rating'];
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("INSERT INTO satisfactions (user_id, event_id, satisfaction, rating) VALUES (:user_id, :event_id, :satisfaction, :rating)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':satisfaction', $satisfaction);
        $stmt->bindParam(':rating', $rating);

        if ($stmt->execute()) {
            $successMessage = "Votre réponse a été soumise avec succès!";
        } else {
            echo "Erreur: " . $stmt->errorInfo()[2];
        }
    }

    $stmt = $conn->prepare("SELECT s.satisfaction, s.rating, u.username FROM satisfactions s JOIN users u ON s.user_id = u.id WHERE s.event_id = :event_id ORDER BY s.id DESC");
    $stmt->bindParam(':event_id', $event_id);
    $stmt->execute();
    $satisfactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM satisfactions WHERE event_id = :event_id");
    $stmt->bindParam(':event_id', $event_id);
    $stmt->execute();
    $avg_rating = $stmt->fetch(PDO::FETCH_ASSOC)['avg_rating'];

} catch(PDOException $e) {
    echo "Erreur: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="satisfaction.css">
    <title>Satisfaction</title>
</head>
<body>
    <div class="container">
        <form method="post" action="">
            <h2>Événement: <br><?php echo htmlspecialchars($event['name']); ?></h2>
            <label for="satisfaction">Votre satisfaction:</label>
            <textarea name="satisfaction" id="satisfaction" required></textarea>
            <label for="rating">Note (1 à 5):</label>
            <select name="rating" id="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <input type="submit" value="Soumettre">
            <?php if ($successMessage) : ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
            <?php endif; ?>
        </form>
        <div class="satisfaction-list">
            <h3>Commentaires des utilisateurs</h3>
            <?php foreach ($satisfactions as $satisfaction) : ?>
                <div class="satisfaction-item">
                    <p><strong><?php echo htmlspecialchars($satisfaction['username']); ?>:</strong> <?php echo htmlspecialchars($satisfaction['satisfaction']); ?> (Note: <?php echo $satisfaction['rating']; ?>)</p>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="avg-rating">Note moyenne: 
            <?php 
                if ($avg_rating !== null) {
                    echo round($avg_rating, 2);
                } else {
                    echo "Pas encore de notes";
                }
            ?>
        </p>
    </div>
    <h9>f</h9>
    <?php include 'footer.php'; ?>
</body>
</html>