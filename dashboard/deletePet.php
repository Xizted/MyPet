<?php
require_once '../includes/functions.php';
require_once DB_URL;

if (!isAuth()) {
    header('Location: /auth/login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || empty($_GET['id'])) {
    header('Location: /dashboard');
    return;
}

$db = db_connect();

$id = $_GET['id'];

$query = 'SELECT photo from pet WHERE id = ?';
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
$imgTemp = $stmt->fetch(PDO::FETCH_ASSOC);

unlink('../uploads/' . $imgTemp["photo"]);

$query = 'DELETE FROM pet WHERE id = ?';
$stmt = $db->prepare($query);
$stmt->bindParam(1, $id);
$stmt->execute();
header('Location: /dashboard');
