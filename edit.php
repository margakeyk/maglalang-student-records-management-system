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

$student_number = $student['student_number'];
$first_name = $student['first_name'];
$last_name = $student['last_name'];
$email = $student['email'];
$course = $student['course'];
$year_level = $student['year_level'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number = trim($_POST['student_number'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $year_level = $_POST['year_level'] ?? '';

    if ($student_number === '' || $first_name === '' || $last_name === '' ||
        $email === '' || $course === '') {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (!in_array($year_level, ['1', '2', '3', '4', '5', '6'], true)) {
        $error = 'Please select a year level from 1 to 6.';
    } elseif (mb_strlen($student_number) > 30 || mb_strlen($first_name) > 80 ||
        mb_strlen($last_name) > 80 || mb_strlen($email) > 120 || mb_strlen($course) > 120) {
        $error = 'One or more fields are too long. Please shorten your entry.';
    }

    if ($error === '') {
        // Placeholders keep form values separate from the SQL statement.
        $stmt = mysqli_prepare($conn, 'UPDATE students SET student_number=?, first_name=?, last_name=?, email=?, course=?, year_level=? WHERE id=?');
        if (!$stmt) {
            $error = 'Cannot save the record. Please check the database table.';
        } else {
            mysqli_stmt_bind_param($stmt, 'sssssii', $student_number, $first_name, $last_name, $email, $course, $year_level, $id);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: index.php');
                exit;
            } elseif (mysqli_stmt_errno($stmt) === 1062) {
                $error = 'That student number already exists.';
            } else {
                $error = 'Could not save the student. Please try again.';
            }
            mysqli_stmt_close($stmt);
        }
    }
}
$page_title = 'Edit Student';
$button_text = 'Save Changes';
include 'header.php';
include 'form.php';
include 'footer.php';
