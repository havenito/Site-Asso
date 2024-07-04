<?php 
 include 'header.php'; 
include_once 'session.php';


if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username_db = "root";
$password_db = "Enzolise1976.";
$dbname = "mirashow";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['comment'])) {
            $comment = $_POST['comment'];
            $user_id = $_SESSION['user_id'];

            $stmt = $conn->prepare("INSERT INTO comments (user_id, comment) VALUES (:user_id, :comment)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':comment', $comment);
            $stmt->execute();
        } elseif (isset($_POST['edit_comment']) && isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $comment = $_POST['edit_comment'];
            $user_id = $_SESSION['user_id'];

            $stmt = $conn->prepare("UPDATE comments SET comment = :comment WHERE id = :comment_id AND user_id = :user_id");
            $stmt->bindParam(':comment', $comment);
            $stmt->bindParam(':comment_id', $comment_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        } elseif (isset($_POST['delete_comment']) && isset($_POST['comment_id'])) {
            $comment_id = $_POST['comment_id'];
            $user_id = $_SESSION['user_id'];

            $stmt = $conn->prepare("DELETE FROM comments WHERE id = :comment_id AND user_id = :user_id");
            $stmt->bindParam(':comment_id', $comment_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }
    }

    $stmt = $conn->prepare("SELECT c.id, c.comment, u.username, u.id as user_id FROM comments c JOIN users u ON c.user_id = u.id ORDER BY c.id DESC");
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT e.id, e.name, e.date, e.location, AVG(s.rating) as avg_rating FROM events e LEFT JOIN satisfactions s ON e.id = s.event_id GROUP BY e.id ORDER BY e.date DESC");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="questionnaire.css">
    <title>Questionnaire</title>
</head>
<body>
<section class="feedback">
    <h2>Donnez votre avis sur nos événements</h2>
    <div class="event-list">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event" data-id="<?php echo $event['id']; ?>" onclick="redirectToSatisfaction(<?php echo $event['id']; ?>)">
                    <div class="event-thumbnail"></div>
                    <div class="event-info">
                        <h3><?php echo htmlspecialchars($event['name']); ?></h3>
                        <p>le <?php echo htmlspecialchars($event['date']); ?>, <?php echo htmlspecialchars($event['location']); ?></p>
                        <p>Note moyenne: <?php echo $event['avg_rating'] !== null ? number_format($event['avg_rating'], 1) : 'Pas encore noté'; ?>/5</p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun événement à afficher.</p>
        <?php endif; ?>
    </div>
</section>

<section class="comments">
    <h2>Commentaires libres</h2>
    <form method="post" action="">
        <textarea name="comment" placeholder="commentaires libres" required></textarea><br>
        <button type="submit">Soumettre</button>
    </form>
    <div class="comment-list">
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment" data-comment-id="<?php echo $comment['id']; ?>">
                    <p><strong><?php echo htmlspecialchars($comment['username']); ?>:</strong> <span class="comment-text"><?php echo htmlspecialchars($comment['comment']); ?></span></p>
                    <?php if ($comment['user_id'] == $_SESSION['user_id']): ?>
                        <button class="edit-button">Modifier</button>
                        <button class="delete-button">Supprimer</button>
                        <form method="post" action="" class="edit-form" style="display: none;">
                            <textarea name="edit_comment" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>
                            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                            <button type="submit">Enregistrer</button>
                            <button type="button" class="cancel-button">Annuler</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun commentaire à afficher.</p>
        <?php endif; ?>
    </div>
</section>
<h3>f</h3>
<script>
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            var commentDiv = this.closest('.comment');
            var editForm = commentDiv.querySelector('.edit-form');
            var commentText = commentDiv.querySelector('.comment-text');

            commentText.style.display = 'none';
            this.style.display = 'none';
            commentDiv.querySelector('.delete-button').style.display = 'none';
            editForm.style.display = 'block';
        });
    });

    document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function() {
            var commentDiv = this.closest('.comment');
            var editForm = commentDiv.querySelector('.edit-form');
            var commentText = commentDiv.querySelector('.comment-text');

            commentText.style.display = 'inline';
            commentDiv.querySelector('.edit-button').style.display = 'inline';
            commentDiv.querySelector('.delete-button').style.display = 'inline';
            editForm.style.display = 'none';
        });
    });

    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            var commentDiv = this.closest('.comment');
            var commentId = commentDiv.getAttribute('data-comment-id');

            if (confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')) {
                var form = document.createElement('form');
                form.method = 'post';
                form.action = '';

                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'comment_id';
                input.value = commentId;
                form.appendChild(input);

                var deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_comment';
                deleteInput.value = '1';
                form.appendChild(deleteInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    function redirectToSatisfaction(eventId) {
        window.location.href = 'satisfaction.php?event_id=' + eventId;
    }
</script>

<?php include 'footer.php'; ?>
</body>
</html>