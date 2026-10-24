<?php
require 'security.php';
require 'db.php';

$student_number = '';
$first_name = '';
$last_name = '';
$email = '';
$course = '';
$year_level = '';
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
        $stmt = mysqli_prepare($conn, 'INSERT INTO students (student_number, first_name, last_name, email, course, year_level) VALUES (?, ?, ?, ?, ?, ?)');
        if (!$stmt) {
            $error = 'Cannot save the record. Please check the database table.';
        } else {
            mysqli_stmt_bind_param($stmt, 'sssssi', $student_number, $first_name, $last_name, $email, $course, $year_level);
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
$page_title = 'Add Student';
$button_text = 'Add Student';
include 'header.php';
include 'form.php';
include 'footer.php';
