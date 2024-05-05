<?php
$host = "303.itpwebdev.com";
$user = "guoe_db_user";
$pass = "uscitp303";
$db = "guoe_assignment_m3";
$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_errno) {
    echo json_encode(['error' => 'Failed to connect to MySQL: ' . $mysqli->connect_error]);
    exit();
}

$courseId = $_GET['courseId'];
$sql = "SELECT title, description, instructor_id, subject_id, TO_BASE64(img) AS img FROM courses WHERE id = ?";

$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Failed to prepare statement: ' . $mysqli->error]);
    exit();
}

$stmt->bind_param("i", $courseId);
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
    exit();
}

$result = $stmt->get_result();
if ($result) {
    $courseDetails = $result->fetch_assoc();
    echo json_encode($courseDetails);
} else {
    echo json_encode(['error' => 'Failed to fetch results: ' . $mysqli->error]);
    exit();
}

$stmt->close();
$mysqli->close();
?>
