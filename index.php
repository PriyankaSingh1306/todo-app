<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_task'])) {
        $title = $_POST['title'];
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
        $stmt->execute([$user_id, $title]);
    } elseif (isset($_POST['edit_task'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $stmt = $pdo->prepare("UPDATE tasks SET title = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $id, $user_id]);
    } elseif (isset($_POST['delete_task'])) {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
    } elseif (isset($_POST['complete_task'])) {
        $id = $_POST['id'];
        $completed = $_POST['completed'] == 'true' ? 1 : 0;
        $stmt = $pdo->prepare("UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$completed, $id, $user_id]);
    }
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>
<h2>Your Tasks</h2>
<form method="POST">
    <input type="text" name="title" placeholder="New task" required>
    <button type="submit" name="add_task">Add Task</button>
</form>

<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>">
                <input type="checkbox" name="completed" value="true" <?php echo $task['completed'] ? 'checked' : ''; ?>>
                <button type="submit" name="complete_task">Complete</button>
                <button type="submit" name="edit_task">Edit</button>
                <button type="submit" name="delete_task">Delete</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
<?php include '../includes/footer.php'; ?>
