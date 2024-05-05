<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Successfully updated a lesson. Check the home page for changes.">
    <title>Update Process</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>SuperLearner</h1>
    </header>

    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="create.php">Create</a></li>
            <li><a href="update.php">Update</a></li>
            <li><a href="delete.php">Delete</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>

    <main>
        <section id="update-process" class="crud-section">
            <h2>Update Confirmation</h2>
            <?php
            $host = "303.itpwebdev.com";
            $user = "guoe_db_user";
            $pass = "uscitp303";
            $db = "guoe_assignment_m3";

            $mysqli = new mysqli($host, $user, $pass, $db);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to MySQL: " . $mysqli->connect_error;
                exit();
            }

            if (isset($_POST['id'], $_POST['instructor'], $_POST['subject'], $_POST['email'], $_POST['course-title']) &&
                !empty($_POST['id']) && !empty($_POST['instructor']) && !empty($_POST['subject']) &&
                !empty($_POST['email']) && !empty($_POST['course-title'])) {

                $id = $_POST['id'];
                $instructor_id = $_POST['instructor'];
                $subject_id = $_POST['subject'];
                $email = $mysqli->real_escape_string($_POST['email']);
                $title = $mysqli->real_escape_string($_POST['course-title']);
                $description = isset($_POST['course-description']) ? $mysqli->real_escape_string($_POST['course-description']) : NULL;
                $picture = NULL;

                if (isset($_FILES['course-picture'])) {
                    if ($_FILES['course-picture']['error'] === UPLOAD_ERR_OK) {
                        $picture = file_get_contents($_FILES['course-picture']['tmp_name']);
                    } else {
                        echo "<p>File upload error. Error Code: " . $_FILES['course-picture']['error'] . "</p>";
                    }
                }

                if ($picture) {
                    $sql = "UPDATE courses SET title = ?, description = ?, instructor_id = ?, subject_id = ?, img = ? WHERE id = ?";
                    if ($stmt = $mysqli->prepare($sql)) {
                        $stmt->bind_param("ssiiib", $title, $description, $instructor_id, $subject_id, $picture, $id);
                        $stmt->send_long_data(4, $picture);
                    }
                } else {
                    $sql = "UPDATE courses SET title = ?, description = ?, instructor_id = ?, subject_id = ? WHERE id = ?";
                    if ($stmt = $mysqli->prepare($sql)) {
                        $stmt->bind_param("sssii", $title, $description, $instructor_id, $subject_id, $id);
                    }
                }

                if ($stmt) {
                    if ($stmt->execute()) {
                        echo "<p>Lesson updated successfully!</p>";
                    } else {
                        echo "<p>Error updating record: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Error preparing statement: " . $mysqli->error . "</p>";
                }
            } else {
                echo "<p>Error: All required fields must be filled, and the file upload must be successful.</p>";
            }

            $mysqli->close();
            ?>
        </section>
    </main>
</body>
</html>
