<?php
include 'pdo.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// CSRF token setup
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed.");
    }

    $message = trim($_POST['message'] ?? '');
    if (!empty($message)) {
        $sql = "INSERT INTO message (content, user_id) VALUES (:content, :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':content' => htmlentities($message, ENT_QUOTES, 'UTF-8'),
            ':user_id' => $_SESSION['user_id']
        ]);
        header('Location: index.php');
        exit;
    }
}

// Fetch messages
try {
    $sql = "SELECT * FROM message ORDER BY id";
    $stmt = $pdo->query($sql);
} catch (PDOException $e) {
    die("Error fetching messages: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Chat App</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <div class="row p-2 bg-color-green">
        <h2 class="col-12">Online Chat App</h2>
    </div>
    <div class="row p-2 bg-color-gray">
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="col-12">
                <div class="d-flex">
                    <div class="message <?= $row['user_id'] == $_SESSION['user_id'] ? 'my-message' : 'others-message' ?>">
                        <b class="message-header">
                            <?= $row['user_id'] == $_SESSION['user_id'] ? 'Me:' : htmlentities($row['user_id'], ENT_QUOTES, 'UTF-8') . ':' ?>
                        </b>
                        <div><?= htmlentities($row['content'], ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <form class="row p-2 bg-color-green send-message" action="index.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="col-9 col-md-10">
            <input type="text" name="message" class="form-control" placeholder="Write your message" required>
        </div>
        <div class="col-3 col-md-2">
            <button type="submit" class="btn btn-light form-control">Send</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
