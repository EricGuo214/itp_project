<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Successfully created a lesson! Check the home page for your new lesson.">
    <title>Create Process</title>
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
        <section id="create-process" class="crud-section">
            <h2>Create Confirmation</h2>
            <?php
            $host = "303.itpwebdev.com";
            $user = "guoe_db_user";
            $pass = "uscitp303";
            $db = "guoe_assignment_m3";

            $mysqli = new mysqli($host, $user, $pass, $db);
            if ($mysqli->connect_errno) {
                echo "Connection error: " . htmlspecialchars($mysqli->connect_error);
                exit();
            }

            if (isset($_POST['instructor'], $_POST['subject'], $_POST['email'], $_POST['course-title']) &&
                !empty($_POST['instructor']) && !empty($_POST['subject']) &&
                !empty($_POST['email']) && !empty($_POST['course-title']) && $_FILES['course-picture']['error'] == UPLOAD_ERR_OK) {

                $title = $mysqli->real_escape_string($_POST['course-title']);
                $description = isset($_POST['course-description']) ? $mysqli->real_escape_string($_POST['course-description']) : NULL;
                $instructor_id = $_POST['instructor'];
                $subject_id = $_POST['subject'];
                $fileTmpPath = $_FILES['course-picture']['tmp_name'];
                $picture = file_get_contents($fileTmpPath);

                $sql = "INSERT INTO courses (title, description, instructor_id, subject_id, img) VALUES (?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ssssb", $title, $description, $instructor_id, $subject_id, $picture);
                    $stmt->send_long_data(4, $picture);

                    if ($stmt->execute()) {
                        echo "<p>Lesson created successfully!</p>";
                    } else {
                        echo "<p>Error: " . $stmt->error . "</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Error preparing statement: " . $mysqli->error . "</p>";
                }
            } else {
                echo "<p>Error: All required fields must be filled and the file must be uploaded successfully.</p>";
                echo "<p>File Upload Error: " . $_FILES['course-picture']['error'] . "</p>";
            }
            $mysqli->close();
            ?>
        </section>
    </main>
</body>
</html>
