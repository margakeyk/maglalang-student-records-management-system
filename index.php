<?php
require 'db.php';
$result = mysqli_query($conn, 'SELECT * FROM students ORDER BY last_name, first_name, id');
if (!$result) {
    exit('Cannot load records. Please import database.sql first.');
}
include 'header.php';
?>
<h2>Student List</h2>
<p>Add, view, edit, and delete student records.</p>
<p><a class="button" href="add.php">Add Student</a></p>
<div class="table-container">
<table>
    <thead>
        <tr><th>Student Number</th><th>Name</th><th>Email</th><th>Course</th><th>Year Level</th><th>Actions</th></tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($result) === 0): ?>
        <tr><td colspan="6">No student records yet.</td></tr>
    <?php endif; ?>
    <?php while ($student = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($student['student_number'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($student['last_name'] . ', ' . $student['first_name'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= (int) $student['year_level'] ?></td>
            <td class="actions"><a href="edit.php?id=<?= (int) $student['id'] ?>">Edit</a> | <a href="delete.php?id=<?= (int) $student['id'] ?>">Delete</a></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
<p>Total students: <?= mysqli_num_rows($result) ?></p>
<?php include 'footer.php'; ?>
