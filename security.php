<?php
// A form token checks that a submitted form came from this browser session.
session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['token']) || !is_string($_POST['token']) ||
        !hash_equals($_SESSION['token'], $_POST['token'])) {
        http_response_code(403);
        exit('Please reload the page and submit the form again.');
    }
}
