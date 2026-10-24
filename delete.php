<?php
require 'security.php';
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    http_response_code(400);
    exit('Invalid student ID.');
}
$stmt = mysqli_prepare($conn, 'SELECT * FROM students WHERE id = ?');
if (!$stmt) { exit('Cannot load student. Please check the database table.'); }
mysqli_stmt_bind_param($stmt, 'i', $id);
if (!mysqli_stmt_execute($stmt)) { exit('Cannot load student. Please try again.'); }
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
if (!$student) {
    http_response_code(404);
    exit('Student not found. Return to the student list.');
}
mysqli_stmt_close($stmt);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = mysqli_prepare($conn, 'DELETE FROM students WHERE id = ?');
    if (!$stmt) { exit('Cannot delete the record. Please check the database table.'); }
    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php');
        exit;
    }
    $error = 'Could not delete the student. Please try again.';
    mysqli_stmt_close($stmt);
}
include 'header.php';
?>
<h2>Delete Student</h2>
<p>Are you sure you want to delete this record?</p>
<p><strong><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name'], ENT_QUOTES, 'UTF-8') ?></strong><br>
Student Number: <?= htmlspecialchars($student['student_number'], ENT_QUOTES, 'UTF-8') ?></p>
<p>This cannot be undone.</p>
<?php if ($error !== ''): ?><p class="error" role="alert"><?= $error ?></p><?php endif; ?>
<form method="post">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') ?>">
    <button type="submit">Delete Student</button>
    <a class="cancel" href="index.php">Cancel</a>
</form>
<?php include 'footer.php'; ?>
